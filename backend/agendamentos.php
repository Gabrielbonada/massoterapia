<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$dbPath = __DIR__ . '/../data/agendamentos.db';
$dataDir = __DIR__ . '/../data';

if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

try {
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $db->exec("CREATE TABLE IF NOT EXISTS agendamentos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT NOT NULL,
        telefone TEXT NOT NULL,
        data TEXT NOT NULL,
        hora TEXT NOT NULL,
        servico TEXT NOT NULL,
        mensagem TEXT,
        status TEXT DEFAULT 'pendente',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['nome']) || !isset($input['email']) || !isset($input['telefone']) || 
        !isset($input['data']) || !isset($input['hora']) || !isset($input['servico'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Campos obrigatórios faltando']);
        exit();
    }
    
    $nome = trim($input['nome']);
    $email = trim($input['email']);
    $telefone = trim($input['telefone']);
    $data = trim($input['data']);
    $hora = trim($input['hora']);
    $servico = trim($input['servico']);
    $mensagem = isset($input['mensagem']) ? trim($input['mensagem']) : '';
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email inválido']);
        exit();
    }
    
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Formato de data inválido']);
        exit();
    }
    
    if (!preg_match('/^\d{2}:\d{2}$/', $hora)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Formato de hora inválido']);
        exit();
    }
    
    try {
        $stmt = $db->prepare("
            INSERT INTO agendamentos (nome, email, telefone, data, hora, servico, mensagem)
            VALUES (:nome, :email, :telefone, :data, :hora, :servico, :mensagem)
        ");
        
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':telefone' => $telefone,
            ':data' => $data,
            ':hora' => $hora,
            ':servico' => $servico,
            ':mensagem' => $mensagem
        ]);
        
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Agendamento realizado com sucesso',
            'id' => $db->lastInsertId()
        ]);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar agendamento']);
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $db->query("SELECT * FROM agendamentos ORDER BY data_criacao DESC");
        $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'data' => $agendamentos
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro ao buscar agendamentos']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>

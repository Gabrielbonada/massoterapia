<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$dbPath = __DIR__ . '/../data/contatos.db';
$dataDir = __DIR__ . '/../data';

if (!is_dir($dataDir)) {
    mkdir($dataDir, 0755, true);
}

try {
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $db->exec("CREATE TABLE IF NOT EXISTS contatos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nome TEXT NOT NULL,
        email TEXT NOT NULL,
        mensagem TEXT NOT NULL,
        lido INTEGER DEFAULT 0,
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Erro ao conectar ao banco de dados']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($input['nome']) || !isset($input['email']) || !isset($input['mensagem'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Campos obrigatórios faltando']);
        exit();
    }
    
    $nome = trim($input['nome']);
    $email = trim($input['email']);
    $mensagem = trim($input['mensagem']);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Email inválido']);
        exit();
    }
    
    if (strlen($mensagem) < 10) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Mensagem muito curta (mínimo 10 caracteres)']);
        exit();
    }
    
    try {
        $stmt = $db->prepare("
            INSERT INTO contatos (nome, email, mensagem)
            VALUES (:nome, :email, :mensagem)
        ");
        
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':mensagem' => $mensagem
        ]);
        
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Mensagem enviada com sucesso',
            'id' => $db->lastInsertId()
        ]);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar mensagem']);
    }
    
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $db->query("SELECT * FROM contatos ORDER BY data_criacao DESC");
        $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'data' => $contatos
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro ao buscar contatos']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método não permitido']);
}
?>

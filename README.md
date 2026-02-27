# Blog & Agendamentos

Um site completo de blog com sistema de agendamentos em HTML, CSS, JavaScript e PHP.

## 📁 Arquivos Inclusos

```
blog_simples/
├── index.html              # Página principal
├── styles.css              # Estilos CSS
├── script.js               # JavaScript
├── backend/
│   ├── agendamentos.php    # API de agendamentos
│   └── contato.php         # API de contato
├── data/                   # Banco de dados (criado automaticamente)
└── README.md               # Este arquivo
```

## 🚀 Instalação Rápida

### 1. Extrair Arquivos
```bash
unzip blog_simples.zip
cd blog_simples
```

### 2. Colocar no Servidor Web
```bash
# Apache/Nginx
cp -r blog_simples /var/www/html/
```

### 3. Acessar no Navegador
```
http://localhost/blog_simples/
```

## ✨ Funcionalidades

- ✅ Blog dinâmico com 6 posts de exemplo
- ✅ Modal para visualizar posts completos
- ✅ Formulário de agendamentos com validação
- ✅ Formulário de contato
- ✅ Banco de dados SQLite automático
- ✅ Menu responsivo
- ✅ Design elegante e responsivo
- ✅ Animações suaves

## 🎨 Design

- **Cores**: Verde (#8c916c), Ouro (#c9a961)
- **Tipografia**: Georgia serif
- **Formas**: Orgânicas e arredondadas
- **Responsivo**: Desktop, Tablet, Mobile

## 📱 Responsividade

- Desktop: 1024px+
- Tablet: 768px - 1023px
- Mobile: até 767px

## 🔧 Requisitos

- PHP 7.4+
- SQLite (incluído no PHP)
- Servidor Web (Apache/Nginx)

## 📊 Banco de Dados

Os bancos de dados SQLite são criados automaticamente em `data/`:
- `agendamentos.db` - Agendamentos
- `contatos.db` - Mensagens de contato

## 🎯 Como Personalizar

### Mudar Cores
Edite `styles.css` - seção `:root`:
```css
:root {
    --green: #8c916c;
    --accent-gold: #c9a961;
    /* ... mais cores ... */
}
```

### Adicionar Posts
Edite `script.js` - array `blogPosts`:
```javascript
const blogPosts = [
    {
        id: 1,
        title: "Seu Título",
        excerpt: "Resumo",
        content: "Conteúdo completo",
        image: "URL da imagem",
        date: "Data",
        author: "Autor"
    }
];
```

### Mudar Informações de Contato
Edite `index.html` - seção "Agendamentos":
```html
<div class="info-item">
    <span class="icon">📍</span>
    <p>Seu endereço aqui</p>
</div>
```

## 🐛 Solução de Problemas

### Formulários não funcionam
1. Verifique se o diretório `data/` existe
2. Certifique-se de que PHP tem permissão de escrita
3. Verifique os logs do servidor web

### Imagens não carregam
- Verifique se as URLs estão corretas
- Certifique-se de que as imagens são acessíveis

### Banco de dados não funciona
- Verifique permissões do diretório `data/`
- Certifique-se de que PHP tem suporte a SQLite

## 📚 APIs PHP

### POST /backend/agendamentos.php
```json
{
    "nome": "João Silva",
    "email": "joao@example.com",
    "telefone": "(11) 99999-9999",
    "data": "2024-03-15",
    "hora": "14:30",
    "servico": "consulta",
    "mensagem": "Mensagem opcional"
}
```

### POST /backend/contato.php
```json
{
    "nome": "João Silva",
    "email": "joao@example.com",
    "mensagem": "Sua mensagem aqui"
}
```

## 🔒 Segurança

- Validação de entrada em todos os formulários
- Sanitização de dados antes de salvar
- Proteção contra SQL Injection
- CORS configurado

## 📝 Licença

Livre para usar e modificar conforme necessário.

---

**Desenvolvido com ❤️ para seu sucesso digital.**

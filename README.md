Relatório Técnico: Sistema de Gerenciamento de Notas (Notas MVC)
Data: 30 de junho de 2025

1. Resumo Executivo
Este relatório descreve a arquitetura, funcionalidades e tecnologias do sistema "Notas MVC". Trata-se de uma aplicação web desenvolvida em PHP, seguindo o padrão arquitetural MVC (Model-View-Controller), projetada para permitir que usuários cadastrados criem, gerenciem, arquivem e personalizem notas pessoais. O sistema possui uma interface de usuário moderna e responsiva, com funcionalidades como editor de texto rico (Rich Text), busca dinâmica, personalização de cores para as notas e um modo escuro (dark mode). A interação com o banco de dados é realizada de forma segura utilizando PDO, e a aplicação gerencia sessões de usuário para controle de acesso.

2. Arquitetura do Sistema
O sistema é estruturado sobre o padrão Model-View-Controller (MVC), que promove a separação de responsabilidades entre os diferentes componentes da aplicação.

Model: Representa a camada de dados e a lógica de negócios. Os models são responsáveis por interagir diretamente com o banco de dados para buscar, inserir, atualizar e deletar informações. Nesta aplicação, os models são User.php e Note.php. Eles encapsulam todas as consultas SQL, garantindo que a lógica de dados esteja isolada.

View: É a camada de apresentação, responsável por exibir a interface do usuário (UI). As views são compostas por arquivos PHP que contêm principalmente HTML, CSS e scripts, e renderizam os dados fornecidos pelos controllers. As views estão localizadas em notas/app/views/ e incluem templates reutilizáveis como header.php e footer.php.

Controller: Atua como o intermediário entre o Model e a View. Ele recebe as requisições do usuário, processa os dados (solicitando informações ao Model quando necessário) e carrega a View apropriada para renderizar a resposta. Os controllers da aplicação são AuthController.php, NotesController.php e UserController.php.

O roteamento de URLs é gerenciado pela classe App.php, que interpreta a URL ($_GET['url']) para determinar qual controller e método devem ser executados. O arquivo public/index.php atua como o ponto de entrada único (front controller), inicializando a aplicação.

3. Tecnologias Utilizadas
Back-End:

PHP: Linguagem de programação principal do lado do servidor.

MySQL/MariaDB: Sistema de gerenciamento de banco de dados, conforme definido no arquivo de dump SQL notas_mvc.sql.

PDO (PHP Data Objects): Extensão utilizada para a comunicação com o banco de dados de forma segura, prevenindo injeção de SQL através de prepared statements.

Front-End:

HTML5: Linguagem de marcação para a estrutura das páginas.

CSS3: Utilizado para estilização, incluindo um sistema de temas claro/escuro com variáveis CSS.

JavaScript (ES6): Para interatividade dinâmica do lado do cliente, como manipulação de modais, chamadas AJAX e busca em tempo real.

Bootstrap 5.3: Framework CSS/JS para a criação de uma interface responsiva e componentes de UI como modais, dropdowns e o sistema de grid.

TinyMCE: Editor de texto "What You See Is What You Get" (WYSIWYG) integrado para a criação e edição do conteúdo das notas.

Bootstrap Icons: Biblioteca de ícones utilizada na interface.

4. Estrutura do Banco de Dados
O banco de dados, chamado notas_mvc, contém duas tabelas principais, conforme descrito em notas_mvc.sql.

Tabela users: Armazena as informações dos usuários.

id (INT, PK, AI): Identificador único do usuário.

name (VARCHAR): Nome do usuário.

email (VARCHAR, UNIQUE): E-mail do usuário, usado para login.

password (VARCHAR): Senha do usuário, armazenada de forma criptografada (password_hash).

created_at (TIMESTAMP): Data de criação do registro.

Tabela notes: Armazena as notas criadas pelos usuários.

id (INT, PK, AI): Identificador único da nota.

user_id (INT, FK): Chave estrangeira que referencia users(id). Garante que cada nota pertença a um usuário. A restrição ON DELETE CASCADE remove as notas do usuário caso ele seja deletado.

title (VARCHAR): Título da nota.

content (TEXT): Conteúdo da nota, que pode incluir HTML do editor TinyMCE.

color (VARCHAR): Código hexadecimal da cor de fundo da nota (padrão #ffffff).

is_archived (TINYINT): Flag booleana (0 ou 1) para indicar se a nota está arquivada.

is_pinned (TINYINT): (Não presente no SQL inicial, mas inferido pelo código) Flag booleana para indicar se a nota está fixada no topo.

created_at (TIMESTAMP): Data de criação da nota.

updated_at (TIMESTAMP): Data da última atualização, atualizada automaticamente (ON UPDATE current_timestamp()).

5. Análise Funcional (Features)
O sistema oferece as seguintes funcionalidades principais:

Autenticação de Usuários:

Registro: Novos usuários podem criar uma conta fornecendo nome, e-mail e senha. O sistema valida os dados, como a complexidade da senha e a unicidade do e-mail.

Login: Usuários registrados podem acessar o sistema com e-mail e senha. A senha é verificada usando password_verify. Uma sessão é criada para o usuário autenticado.

Logout: O usuário pode encerrar sua sessão de forma segura.

Controle de Acesso: A maioria das rotas, como a visualização de notas, é protegida e só pode ser acessada por usuários autenticados.

Gerenciamento de Notas (CRUD):

Criar: Usuários podem criar novas notas através de um modal, inserindo título, conteúdo (com o editor TinyMCE) e selecionando uma cor de fundo.

Visualizar/Ler: As notas são exibidas em um layout de grade na página principal. Notas arquivadas são mostradas em uma página separada.

Atualizar: Clicar em uma nota abre um modal de edição, permitindo alterar título, conteúdo e cor.

Excluir: As notas podem ser excluídas permanentemente tanto da visualização principal quanto da de arquivadas.

Funcionalidades Adicionais:

Arquivamento: Notas podem ser arquivadas para "limpar" a tela principal e desarquivadas posteriormente.

Fixar Notas: É possível fixar notas importantes, que serão sempre exibidas no topo da lista.

Personalização de Cores: O usuário pode atribuir cores diferentes a cada nota para melhor organização visual.

Busca Dinâmica: Um campo de busca na página principal filtra as notas por título ou conteúdo em tempo real, sem recarregar a página.

Modo Escuro (Dark Mode): A interface pode ser alternada entre um tema claro e um escuro. A preferência é salva no localStorage do navegador para persistir entre as visitas.

Gerenciamento de Perfil:

Os usuários podem visualizar e atualizar seus dados de perfil, como nome e e-mail. Também é possível alterar a senha, deixando os campos de senha em branco para mantê-la inalterada.

6. Análise de Código e Componentes
Roteamento (App.php): A classe App é o núcleo do roteador. Ela analisa a variável $_GET['url'], divide-a em segmentos (/controller/method/params) e instancia o controller correspondente, chamando o método solicitado.

Banco de Dados (Database.php): A classe Database é um wrapper para PDO. Ela lida com a conexão e a execução de consultas. O uso dos métodos bind() e execute() garante o uso de prepared statements, uma prática essencial para a segurança contra injeção de SQL.

Interatividade (main.js): O arquivo main.js é fundamental para a experiência do usuário. Ele é responsável por:

Inicializar o editor TinyMCE nos modais de criação e edição.

Gerenciar o tema claro/escuro e sua persistência.

Lidar com as chamadas AJAX (via fetch) para ações como arquivar, fixar e excluir notas. Isso permite que essas ações ocorram sem um recarregamento completo da página, embora a implementação atual opte por recarregar (window.location.reload()) após o sucesso da operação.

Preencher dinamicamente os modais de edição e de visualização de notas arquivadas com os dados da nota selecionada, buscando-os do servidor através da rota notes/show/{id}.

Implementar a funcionalidade de busca do lado do cliente, ocultando e exibindo as notas conforme o termo digitado.

7. Pontos Fortes e Recomendações
Pontos Fortes:

Boa Estrutura: A adoção do padrão MVC torna o código organizado, escalável e de fácil manutenção.

Segurança: O uso de PDO com prepared statements e o hashing de senhas com password_hash são práticas de segurança robustas.

Experiência do Usuário (UX): A interface é limpa e moderna. Funcionalidades como busca instantânea, AJAX para ações, modo escuro e um editor de texto rico melhoram significativamente a usabilidade.

Reutilização de Código: O uso de templates de view (header.php, footer.php) e helpers de sessão/URL evita a duplicação de código.

Recomendações de Melhoria:

URL Amigável (Pretty URLs): A estrutura de URL atual (/public/index.php?url=...) poderia ser melhorada para URLs mais limpas (ex: /notes/edit/1) usando um arquivo .htaccess com mod_rewrite no servidor Apache.

Tratamento de Erros: O tratamento de erros de AJAX no front-end poderia ser mais amigável, exibindo mensagens de erro mais informativas em vez de um alert() genérico ou falhas silenciosas.

Segurança Adicional:

Implementar proteção contra Cross-Site Request Forgery (CSRF) adicionando tokens únicos a todos os formulários que realizam alterações de estado.

A validação de filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW) seguida por trim() é um bom começo, mas poderia ser mais rigorosa usando filtros de sanitização específicos (ex: FILTER_SANITIZE_STRING, FILTER_SANITIZE_EMAIL) para cada campo.

Eficiência do AJAX: Após uma ação AJAX bem-sucedida (arquivar, fixar, etc.), o main.js recarrega a página inteira (window.location.reload()). Uma abordagem mais eficiente seria manipular o DOM diretamente com JavaScript para refletir a mudança, evitando o recarregamento e proporcionando uma experiência mais fluida.

8. Conclusão
O sistema "Notas MVC" é uma aplicação web bem-sucedida e funcional, construída sobre uma base arquitetural sólida. Ele demonstra um bom entendimento dos princípios de desenvolvimento web moderno em PHP, incluindo segurança, separação de responsabilidades e uma rica experiência de usuário. As recomendações listadas acima representam oportunidades para aprimorar ainda mais a robustez, segurança e eficiência da aplicação.

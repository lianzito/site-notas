**Notas MVC**
Notas MVC é uma aplicação web completa para gerenciamento de notas pessoais, desenvolvida em PHP puro seguindo o padrão arquitetural Model-View-Controller (MVC). O projeto foi criado para demonstrar a implementação de um sistema robusto, seguro e com uma interface de usuário moderna e interativa.

**Funcionalidades Principais**
O sistema oferece uma gama completa de funcionalidades para uma experiência de usuário rica e eficiente:

Autenticação Segura: Sistema completo de Registro e Login com hashing de senhas (password_hash) e controle de sessão.

Gerenciamento de Notas (CRUD):

Criação e Edição com editor de texto rico (TinyMCE).

Visualização em layout de grade.

Exclusão permanente de notas.

Organização Avançada:

Arquivamento: Mova notas para uma seção de arquivadas para manter sua área de trabalho limpa.

Fixar Notas: Marque notas importantes para que sempre apareçam no topo.

Cores Personalizadas: Atribua cores a cada nota para uma melhor organização visual.

Interface Interativa:

Modo Escuro (Dark Mode): Alterne entre temas claro e escuro, com a preferência salva no navegador.

Busca Dinâmica: Filtre notas instantaneamente por título ou conteúdo sem recarregar a página.

Ações via AJAX: Arquive e exclua notas com uma experiência fluida, sem a necessidade de recarregar a página.

Gerenciamento de Perfil: Os usuários podem atualizar suas informações pessoais e alterar a senha.

Arquitetura e Tecnologias
O projeto é construído sobre uma base sólida que promove organização, segurança e escalabilidade.

**Arquitetura MVC**
Model: Camada de dados que interage com o banco de dados via PDO, utilizando prepared statements para prevenir injeção de SQL.

View: Camada de apresentação que renderiza a UI com dados dinâmicos.

Controller: Camada de controle que orquestra o fluxo de dados entre os Models e as Views.

Roteador: Um roteador simples (App.php) lida com as requisições, direcionando-as para o controller e método apropriados.

**Tecnologias Utilizadas**
**Back-End**

PHP, MySQL (ou MariaDB), PDO

**Front-End**

HTML5, CSS3, JavaScript (ES6), AJAX (Fetch API)

Frameworks & Libs

Bootstrap 5, TinyMCE, Bootstrap Icons

**Como Executar o Projeto**
Clone o repositório:

Bash

git clone https://github.com/seu-usuario/notas-mvc.git
cd notas-mvc
Banco de Dados:

Crie um banco de dados com o nome notas_mvc.

Importe o arquivo notas_mvc.sql para criar as tabelas e inserir dados iniciais.

Configuração:

Abra o arquivo config/config.php.

Atualize as constantes DB_USER e DB_PASS com suas credenciais do banco de dados.

Verifique se a URLROOT corresponde à URL do seu ambiente de desenvolvimento local (ex: http://localhost/notas-mvc).

Servidor Local:

Inicie um servidor local (XAMPP, WAMP, MAMP ou o servidor embutido do PHP) na raiz do projeto.

Pronto! Agora você pode acessar a aplicação no seu navegador.

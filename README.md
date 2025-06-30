**Notas MVC**
Notas MVC é uma aplicação web completa para gerenciamento de notas pessoais, desenvolvida em PHP puro com o padrão arquitetural Model-View-Controller (MVC). O projeto foi criado com o objetivo de demonstrar uma implementação robusta, segura e com uma interface moderna e interativa.

** Funcionalidades**
** Autenticação Segura**
Registro e login com hashing de senhas (password_hash) e controle de sessões.

**Gerenciamento de Notas (CRUD)**

Criação e edição com editor de texto rico (TinyMCE)

Visualização em layout de grade

Exclusão permanente de notas

**Organização Avançada
**
Arquivar: Mantenha o ambiente limpo ao mover notas para uma seção de arquivadas

Fixar Notas: Destaque notas importantes no topo

Cores Personalizadas: Classifique visualmente com cores diferentes

**Interface Interativa
**
Modo Escuro: Alternância entre tema claro e escuro com persistência no navegador

Busca Dinâmica: Filtro instantâneo por título ou conteúdo (sem recarregar a página)

Ações via AJAX: Arquivamento e exclusão sem reload

Perfil de Usuário: Atualização de dados pessoais e senha

** Arquitetura e Tecnologias Arquitetura MVC**
Model: Acesso ao banco via PDO, com uso de prepared statements para segurança contra SQL Injection.

View: Camada de apresentação dinâmica, separando lógica da interface.

Controller: Coordena a comunicação entre Model e View.

Roteamento: Arquivo App.php gerencia e direciona as requisições para os controladores e métodos corretos.

**Tecnologias Utilizadas
Back-End**
PHP

MySQL ou MariaDB

PDO

**Front-End**
HTML5, CSS3, JavaScript (ES6)

AJAX com Fetch API

**Bibliotecas & Frameworks**
Bootstrap 5

TinyMCE

Bootstrap Icons

**Como Executar o Projeto**
1. Clone o repositório
bash
Copiar
Editar
git clone https://github.com/seu-usuario/notas-mvc.git
cd notas-mvc
2. Banco de Dados
Crie um banco chamado notas_mvc.

Importe o arquivo notas_mvc.sql que está na raiz do projeto.

3. Configuração
Abra o arquivo config/config.php.

Atualize os valores de DB_USER e DB_PASS com suas credenciais.

Verifique se a constante URLROOT corresponde ao caminho da aplicação no seu ambiente local (ex: http://localhost/notas-mvc).

4. Execute o servidor local
Utilize uma das opções:

XAMPP / WAMP / MAMP

Ou o servidor embutido do PHP:

bash
Copiar
Editar
php -S localhost:8000 -t public
Pronto! Acesse a aplicação pelo navegador e comece a organizar suas notas! ✨


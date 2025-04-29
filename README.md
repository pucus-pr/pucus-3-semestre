# PUCUS

Este é o projeto **Pucus**, uma aplicação desenvolvida para melhorar a comunicação entre alunos, coordenadores e funcionários da PUC, permitindo o reporte de problemas, comunicados e interações em um fórum.

## Requisitos

- XAMPP

## Instalação

1. **Clone o repositório:**

Se ainda não tiver o repositório, clone-o para sua máquina local dentro da pasta htdocs do seu XAMPP:

```bash
   git clone https://github.com/pucus-pr/pucus.git
   cd pucus
```

2. **Crie a database**

Antes de rodar a aplicação, é necessário criar o banco de dados. Crie uma database chamada pucus no banco de dados do XAMPP (ou outro da sua preferência)

3. **Configure a conexão com o banco de dados**

Verifique se o arquivo de configuração de banco de dados está configurado corretamente (config/config.php)

4. **Execute as migrações**

```bash
   php ./database/migrate.php
```

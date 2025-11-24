# README.md

<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"
         width="400" alt="Laravel Logo">
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 📡 Network Operations Manager

Um painel completo desenvolvido para otimizar operações de rede, gerenciar clientes, registrar troubleshootings e centralizar informações técnicas essenciais.  
Criado com **Laravel**, focado em produtividade, organização e velocidade para equipes NOC e operações.

---

## 🚀 Funcionalidades

- Registro completo de Troubleshooting  
- Edição avançada com abas organizadas  
- Pesquisa inteligente com múltiplos filtros  
- Controle de edição por usuário  
- Interface otimizada para ambiente profissional  
- Campos técnicos como:
  - IP (CPE)
  - PE Relacionado
  - Designador
  - VLANs
  - ONU
  - PRTG Link
  - Porta e Circuito
  - Endereço completo
- Histórico de alteração automática (`LAST_EDIT_USER` e `LAST_EDIT_TIME`)
- Suporte a detalhes extras via campo JSON

---

## 🧱 Tecnologias Utilizadas

- PHP 8+
- Laravel 11
- Blade Templates
- MySQL / MariaDB
- Bootstrap 5
- SortableJS
- FontAwesome Icons

---

## 🛠️ Instalação

Clone o repositório:

git clone https://github.com/seu-usuario/seu-projeto.git

Instale as dependências:

composer install
npm install && npm run build

Configure o `.env`:

cp .env.example .env
php artisan key:generate

Configure o banco de dados e rode as migrations:

php artisan migrate

Inicie o servidor:

php artisan serve

---

## 🎯 Estrutura do Projeto

app/
 └── Http/
       └── Controllers/
             └── TroubleshootingController.php

resources/
 └── views/
       └── reuse/
             └── viewEditTroubleshooting.blade.php

---

## 🤝 Contribuição

Pull requests são bem-vindos!  
Para grandes mudanças, abra uma issue primeiro para discutirmos o que deseja alterar.

---

## 🔒 Segurança

Se encontrar alguma falha de segurança, envie uma mensagem privada diretamente ao mantenedor do repositório.

---

## 📄 Licença

Este projeto é distribuído sob a licença MIT, permitindo uso comercial, modificação e redistribuição.

---

## 💚 Apoie este Projeto

Se este sistema te ajudou, considere apoiar com um PIX 💚

<p align="center">
  <img src="public/pix/qrcode.jpeg" width="260" alt="QR Code PIX">
</p>

<p align="center"><strong>Chave PIX:</strong> lealsantanati@gmail.com</p>

---

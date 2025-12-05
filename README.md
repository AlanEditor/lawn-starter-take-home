# 🌌 Projeto Take Home: Star Wars API (SWAPI) Full-Stack

Este projeto implementa uma arquitetura Full-Stack com uma API Laravel para consulta à SWAPI e um Frontend Vue/Vite. A infraestrutura é totalmente gerenciada por Docker Compose.

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP 8.4 (Laravel 11, PHP-FPM)
* **Frontend:** Vue 3 (Vite)
* **Banco de Dados:** MySQL 8.0
* **Cache/Fila:** Redis
* **Proxy/Web Server:** Nginx 1.27
* **Containerização:** Docker Compose

## 🚀 1. Configuração Inicial e Acesso

### 1.1. Adicionar Domínio Local (`/etc/hosts`)

Para evitar o uso de `localhost:PORTA`, a aplicação utiliza um domínio virtual. Você deve mapear este domínio para o seu endereço local.

**Edite o seu arquivo `/etc/hosts`** (localizado em `/private/etc/hosts` no macOS/Linux ou `C:\Windows\System32\drivers\etc\hosts` no Windows) e adicione a seguinte linha:

```text
127.0.0.1 swapi.local
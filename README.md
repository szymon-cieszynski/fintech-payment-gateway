# Fintech Payment Gateway (Bank Simulator)

This project is built with **Symfony 7** and serves as a learning platform for developing a backend‑focused web application.  
The frontend is minimal — the main focus is on **domain logic and architecture**.

## 🧩 Architectural Style

The application is designed according to **Hexagonal Architecture (Ports & Adapters)** principles:

- **Domain Layer (Core)**
    - Entities (`Client`, `Transaction`, etc.)
    - Value Objects (`PersonalData`, `BusinessData`, `ClientType`)
    - Domain Services and invariants

- **Application Layer**
    - Commands (`CreateClientCommand`, `ProcessPaymentCommand`)
    - Handlers (`CreateClientHandler`, etc.)
    - Orchestration of domain logic

- **Ports (Interfaces)**
    - `ClientRepository` (domain contract for persistence)
    - `PaymentGatewayPort` (contract for external payment systems)

- **Adapters (Implementations)**
    - `DoctrineClientRepository` (PostgreSQL persistence)
    - `HttpPaymentGatewayAdapter` (simulated external bank API)
    - CLI / Controller adapters for user interaction

This separation ensures that the **domain logic is independent of frameworks and infrastructure**.
---

## 🛠️ Technologies

- PHP 8.3 + Symfony 7
- PostgreSQL 15
- Nginx
- Docker / Docker Compose
- Adminer (PostgreSQL GUI)

---

## 🚀 Local Setup

The project uses Docker. All containers are defined in the `.docker/` directory.

### 1. Start containers
```bash
cd .docker
make start
```
### 2. Enter PHP container
```bash
make sh
```
### 3. Install PHP dependencies
```bash
composer install
```
### 4. Run database migrations
```bash
make migrate
```
📦 Project Structure

.docker/ - Docker configuration (PHP, Nginx, DB, Adminer)

src/ - Symfony code (domains / bounded contexts will go here)

public/ - entry point of the application

config/ - Symfony configuration

vendor/ - Composer dependencies

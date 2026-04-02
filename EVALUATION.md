# AttilaDesk Project Evaluation Report

## 1. Short Summary
**What the project does:**
AttilaDesk is a compact office administration system designed for small businesses. It handles task management, client administration, holiday/leave tracking, and weekly scheduling through a modular PHP interface.

**Overall code quality impression:**
The project follows a traditional PSR-4 MVC architecture and makes good use of modern dependency management (Composer). However, the implementation is inconsistent, with several **critical security vulnerabilities** and architectural anti-patterns (such as N+1 queries and logic in views) that would make it risky for production use without significant remediation.

---

## 2. What Is Done Well
- **Architectural Foundation:** Good use of MVC separation (Controllers, Models, Views) and PSR-4 autoloading.
- **Dependency Management:** Correct integration of third-party libraries (PHPMailer, PHP-JWT) via Composer.
- **Database Hygiene:** General use of PDO with prepared statements, providing a solid baseline against basic SQL injection.
- **Modularity:** Clear separation of business domains (Task, User, Ugyfel, Szabadsag).

---

## 3. Issues and Risks
- **Critical Security Vulnerabilities:**
    - **Password Hashing:** Uses unsalted SHA256 hashes (`hash('sha256', ...)`) instead of `password_hash()`. This is vulnerable to rainbow table attacks.
    - **Hardcoded Credentials:** SMTP passwords and JWT secret keys are hardcoded in the source code (e.g., `src/app/view/task/send_email.php`).
    - **Direct File Access:** Some functional scripts (like `send_email.php`) can be accessed directly via URL, bypassing authentication checks in `index.php`.
    - **Cross-Site Request Forgery (CSRF):** Total lack of CSRF tokens on state-changing forms (Create/Edit/Delete).
    - **Cross-Site Scripting (XSS):** Inconsistent output escaping; several views echo data directly without `htmlspecialchars()`.
- **Bug-Prone Routing:** A critical assignment typo in `index.php` (`else if($actionName="actionInsert")`) causes unintended behavior during routing.
- **MVC Violations:** Significant business logic and POST handling are embedded directly in View files.

---

## 4. PHP-Specific Evaluation
- **Structure:** Traditional but lacks a centralized Front Controller/Router, leading to manual `if/else` dispatching.
- **Typing:** Minimal use of PHP 7.4+ type hinting (property types, return types).
- **Error Handling:** `display_errors` is enabled in the entry point, which can leak system details to users in a production environment.

---

## 5. MySQL / Database Evaluation
- **Prepared Statements:** Mostly safe, but implementation is inconsistent (mixing named parameters and `?` placeholders).
- **Relational Logic:** The system lacks foreign key constraints (implied by the code) and relies on manual ID matching.
- **Transactions:** No use of database transactions observed, posing a risk to data integrity during complex multi-step operations.

---

## 6. Performance
- **The N+1 Query Problem:** Lists (Tasks, Schedules) fetch related data (Users, Clients) inside loops.
    - *Example:* A list of 50 tasks results in 51 database queries instead of 1 query with a `JOIN`.
- **Resource Management:** Constant re-instantiation of Models inside View loops adds unnecessary overhead.

---

## 7. Concrete Fix List

### Fix 1: Secure Password Hashing
- **Problem:** Weak SHA256 hashing.
- **Why:** Easily reversible if the database is leaked.
- **How:** Use PHP's built-in `password_hash`.
- **Example:**
  ```php
  // Instead of hash('sha256', $pass)
  $hashed = password_hash($password, PASSWORD_DEFAULT);
  // Verification
  if (password_verify($password, $user->getPassword())) { ... }
  ```

### Fix 2: Environment-Based Configuration
- **Problem:** Hardcoded secrets and credentials.
- **Why:** Security breach risk and difficult environment management.
- **How:** Use `vlucas/phpdotenv` and a `.env` file.
- **Example:**
  ```php
  $mail->Password = $_ENV['SMTP_PASSWORD'];
  ```

### Fix 3: Optimize Data Fetching (Fix N+1)
- **Problem:** High database load on list views.
- **Why:** Performance degrades exponentially as data grows.
- **How:** Use SQL `JOIN`s in the Model's `findAll` methods.
- **Example:**
  ```sql
  SELECT task.*, user.nickname
  FROM task
  LEFT JOIN user ON task.user_id = user.id
  ```

### Fix 4: Output Escaping (XSS Prevention)
- **Problem:** Raw output in views.
- **Why:** Allows malicious script injection.
- **How:** Always wrap dynamic output in `htmlspecialchars()`.

---

## 8. Priority Classification
| Issue | Severity | Category |
| :--- | :--- | :--- |
| **Password Hashing** | **Critical** | Security |
| **Hardcoded SMTP/JWT Secrets** | **Critical** | Security |
| **Routing Typo (`index.php`)** | **Critical** | Bug |
| **Direct Script Access** | **Important** | Security |
| **CSRF / XSS Gaps** | **Important** | Security |
| **N+1 Query Bottlenecks** | **Important** | Performance |
| **Logic in Views** | **Improvement** | Maintainability |
| **Modern PHP Typing** | **Improvement** | Code Quality |

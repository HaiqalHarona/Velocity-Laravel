# Velocity

A Real-Time Kanban Project Management System [Link to the website](velocity.effoc.org)

Built with Laravel, Reverb WebSocket, Livewire, and Bootstrap. Self-hosted on a two-server homelab infrastructure with Cloudflare Tunnel, Nginx, PHP-FPM, Portainer, and a private MySQL database.

---

## Overview

Velocity is a full-stack, real-time project management application built in the Kanban style. It allows teams to create workspaces, manage boards and tasks, and collaborate in real time. Every card move, label change, and comment is broadcast instantly to all connected team members using Laravel Reverb WebSocket, without requiring a page refresh.

The project was built from scratch over five months as a self-directed learning exercise, with no prior experience in most of the technologies used. Primary references included official documentation and AI-assisted debugging, primarily using Google Gemini.

---

## System Features & Engineering Walkthrough

### 1. Authentication, Authorization & Security
- **Hybrid Authentication Engine**: Supports native session-based authentication (complete with SMTP-driven email verification and password reset flows) alongside OAuth 2.0 integrations (Google & GitHub) implemented via **Laravel Socialite**.
- **Workspace-Level RBAC**: A fine-grained Role-Based Access Control (RBAC) matrix separating workspace access into three operational tiers: `Owner` (full administrative rights, billing/deletion permissions), `Admin` (workspace and user management), and `Member` (collaborative board access). Permissions are enforced backend-side using Laravel **Policies** and **Gates**.
- **Cryptographic Invitations**: Secure, out-of-band member onboarding via cryptographically signed invitation tokens with expiration controls, dispatched asynchronously using Laravel Mailables and queue workers.

### 2. Kanban Board & Task Management Engine
- **Hierarchical Domain Model**:
  - `Workspace`: Tenant-like boundary isolation.
  - `Board`: Layout container referencing lists and cards.
  - `List`: Vertical lane configuration with sequential position tracking.
  - `Card`: Task-level entity with nested sub-resources.
- **Stateful Drag-and-Drop Reordering**: Custom-tuned sorting algorithms handling list-to-list card migration and intra-list sorting. Mutated list offsets and card indexes are persisted using optimized index update queries.
- **Sub-Resource Support**:
  - **Checklists**: Nested task list tracks completion progress dynamically.
  - **Dynamic Tags**: Highly-customizable workspace-wide color and label tags.
  - **Metadata Tracking**: Structured properties for due dates, description fields (Markdown format-ready), and archival flags.
  - **Audit Logs / Activity Feeds**: Event-driven tracking logs audit changes (e.g., card moved, member assigned, checklist completed) to render a detailed history panel per card.

### 3. Real-Time Collaboration & Synchronization
- **WebSocket Broadcast Architecture**: Replaces polling models entirely. Live board state changes are broadcast over a native, self-hosted **Laravel Reverb** WebSocket daemon.
- **Client Synchronization**: Frontend client instances listen to private boards channels (`private-board.{id}`) via **Laravel Echo**. UI state updates instantly on remote client browsers whenever cards are mutated, moved, or deleted.
- **Presence & Presence Channels**: Real-time tracking of active board viewers (`presence-board.{id}`) showing avatar lists of who is currently online and viewing the board.

---

## Developer & Technology Stack

The stack is designed for low overhead, fast prototyping, and minimal external SaaS dependencies.

| Component | Technology | Description / Usage |
|---|---|---|
| **Language & Runtime** | PHP 8.2+ | Modern PHP execution, utilizing type hinting, constructor promotion, and strict typing. |
| **Backend Framework** | Laravel 11 | Main application controller, container registry, routing, Eloquent ORM, and broadcasting. |
| **Reactive UI** | Livewire 3 + Alpine.js | Reactive HTML-over-the-wire component updates, replacing the need for a complex Vue/React client. |
| **WebSocket Engine** | Laravel Reverb | High-performance, event-loop driven WebSocket server written in PHP, running as a daemon. |
| **Database** | MySQL 8.0 | Core relational database engine running in a **privately-hosted homelab environment** for both Dev and Production. |
| **Auth Provider** | Laravel Socialite | Clean provider mapping for external OAuth services. |
| **Email Transport** | SMTP | Secure integration for dispatching transactional mail. |
| **Web Server** | Nginx | High-performance reverse proxy for proxying HTTP requests and upgrading WebSocket channels. |
| **Process Manager** | PHP-FPM | FastCGI Process Manager handler for isolating web requests. |
| **Containerization** | Docker | Infrastructure-as-code deployment with `docker-compose` files. |
| **Tunneling** | Cloudflare Tunnel | Secure egress-only proxy, avoiding public ingress port forwarding. |

### Database Hosting Architecture
To minimize reliance on cloud hosting provider fees and maintain full data ownership, the database layer is designed as follows:
- **Engine**: MySQL 8.0 with optimized indexing for task sorting and relational keys.
- **Hosting Environment**: Privately hosted in a personal **homelab** network.
- **Environments**: Both **Development** and **Production** environments utilize dedicated MySQL instances hosted on local server hardware.
- **Security**: The database server is completely isolated in a private subnet, accessible only by the application server via virtual local network routing. No MySQL ports (`3306`) are exposed to the public internet.

---

## Infrastructure & Homelab Architecture

The production and development deployment maps to local homelab environments using a two-tier hardware division:

```
                  +--------------------------------------------------+
                  |                 Public Internet                  |
                  +--------------------------------------------------+
                                           |
                                           v
                             [ Cloudflare CDN & DNS ]
                                           |
                                           | (Secure Cloudflare Tunnel)
                                           v
+-----------------------------------------------------------------------------------------+
| Homelab Local Area Network (LAN)                                                        |
|                                                                                         |
|  +-----------------------------------------------------------------------------------+  |
|  | Application Server (Physical Host / VM / Docker Host)                             |  |
|  |                                                                                   |  |
|  |  +--------------------+                                                           |  |
|  |  | cloudflared Daemon | <----------------------------------+                      |  |
|  |  +--------------------+                                    |                      |  |
|  |            |                                               |                      |  |
|  |            | (Internal Forwarding)                         |                      |  |
|  |            v                                               v                      |  |
|  |  +----------------------------------+            +-----------------------------+  |
|  |  | Nginx Web Server (Port 80/443)   |            | Laravel Reverb (Port 8080)  |  |
|  |  +----------------------------------+            +-----------------------------+  |
|  |            | (FastCGI Protocol)                            ^                      |  |
|  |            v                                               | (Websocket Broadcast)|  |
|  |  +----------------------------------+                      |                      |  |
|  |  | PHP-FPM Application Worker       | ---------------------+                      |  |
|  |  +----------------------------------+                                             |  |
|  +-----------------------------------------------------------------------------------+  |
|                               |                                                         |
|                               | (Private LAN Routing - Isolated MySQL Access)           |
|                               v                                                         |
|  +-----------------------------------------------------------------------------------+  |
|  | Database Server (Dedicated Physical Host / VM)                                    |  |
|  |                                                                                   |  |
|  |  +----------------------------------+                                             |  |
|  |  | MySQL Daemon (Port 3306)         |                                             |  |
|  |  +----------------------------------+                                             |  |
|  +-----------------------------------------------------------------------------------+  |
+-----------------------------------------------------------------------------------------+
```

### Application / Edge Layer
- **Cloudflare Tunnel (`cloudflared`)**: Runs containerized on the app server. It connects outward to the Cloudflare network, enabling SSL termination and proxying of standard web and WebSocket traffic back into the local environment without any router port forwarding.
- **Nginx & PHP-FPM**: Serves as the web server, proxying requests to PHP-FPM for execution and routing WebSocket connections to the Reverb server.
- **Laravel Reverb**: Handles WebSocket upgrading requests. It listens for system broadcast notifications sent via API and pushes the updates to active WebSocket connections.

### Database Layer
- **MySQL Private Homelab Host**: A dedicated server (separate VM or physical server in the homelab) running MySQL 8.0.
- **Private Subnet Access**: The application server communicates with the MySQL server over a private local network interface. The MySQL instance binds strictly to local interface addresses, meaning it is immune to external network scans and direct attacks from the internet.

---

## Database Schema

The schema is included in this repository as `velocity_schema.sql`. Key entities include:

- `users` - Accounts created via email or OAuth
- `workspaces` - Top-level organizational unit
- `workspace_members` - Pivot table with role assignments
- `boards` - Kanban boards belonging to a workspace
- `lists` - Ordered columns within a board
- `cards` - Tasks within a list, with ordering support
- `card_labels`, `card_checklists`, `card_activities` - Card metadata and audit trail
- `invitations` - Pending workspace invitations sent by email

---

## OAuth Application Setup

### Google OAuth

- Go to [console.cloud.google.com](https://console.cloud.google.com) and create a new project
- Enable the Google+ API or People API
- Create OAuth 2.0 credentials under APIs and Services
- Add your callback URL: `https://yourdomain.com/auth/google/callback`
- Copy the client ID and secret into your `.env` file

### GitHub OAuth

- Go to [github.com/settings/developers](https://github.com/settings/developers) and register a new OAuth App
- Set the Authorization callback URL to `https://yourdomain.com/auth/github/callback`
- Copy the client ID and secret into your `.env` file

---

## Production Deployment Notes

### Nginx Configuration

Nginx is configured to route standard HTTP requests to PHP-FPM and WebSocket upgrade requests to the Reverb process. The relevant configuration must handle:

- PHP-FPM `fastcgi_pass` for all `.php` requests
- Proxy pass to the Reverb port (default `8080`) for WebSocket connections
- WebSocket headers: `Upgrade` and `Connection` must be forwarded correctly

### Cloudflare Tunnel

A `cloudflared` daemon runs on the application server and maintains a persistent outbound tunnel to Cloudflare. This eliminates the need to open inbound firewall ports. DNS is managed through Cloudflare, and the tunnel handles both HTTPS and WebSocket traffic.

### Process Management

- Reverb runs as a supervised background process inside its container
- Queue workers for email dispatch are also run as persistent supervised processes
- Portainer provides a web UI for container lifecycle management and log inspection

---

## Repository Contents

| File / Directory | Description |
|---|---|
| `notion-budget/` | Main Laravel application source code |
| `velocity_schema.sql` | Full MySQL schema dump |
| `schema-diagram.png` | Entity-relationship diagram |
| `Logo.png` / `Logo.ai` | Project logo assets |

---

## Project Background

Velocity was built over five months as a personal learning project, starting with no prior experience in Laravel, Livewire, WebSockets, or server infrastructure. The development process relied heavily on official documentation and AI-assisted debugging, with Google Gemini used as the primary debugging assistant throughout the project.

The scope expanded progressively as each subsystem was learned: starting with basic Laravel MVC, then Livewire reactivity, then real-time broadcasting with Reverb, then OAuth integration, and finally self-hosted infrastructure with Docker, Nginx, and Cloudflare Tunnel.

The project represents a complete end-to-end implementation of a production-grade collaborative tool, built and deployed independently.

---

## License

This project is open source and available for personal and educational use. No formal license is attached. Attribution is appreciated but not required.

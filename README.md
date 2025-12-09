
# SWAPI Take-Home – Full Stack

This project was developed as part of the **LawnStarter** take-home assignment.

The goal is to implement a complete application that:

* Queries the **Star Wars API (SWAPI)** through a Laravel backend
* Renders results strictly following the **Zeplin mockups**
* Stores request logs and generates **automatic statistics** (via events + queues + scheduler)
* Runs entirely on **Docker**, with **a single command** to start everything

---

## Technologies Used

### Backend

* PHP 8.x
* Laravel 10
* Redis (queues + cache)
* MySQL 8
* NGINX
* Jobs / Events / Scheduler

### Frontend

* Vue 3 (Composition API)
* Vite
* TailwindCSS

### Infrastructure

* Docker and Docker Compose
* Dedicated containers for:

    * backend
    * frontend
    * mysql
    * redis
    * scheduler
    * queue worker

---

# How to Run the Project (1 command)

After cloning the repository:

```bash
git clone https://github.com/YOUR_USERNAME/swapi-takehome.git
cd swapi-takehome

# Make all scripts executable
chmod +x *.sh

# Start the entire environment
./start.sh
```

This command:

* Copies `.env` if missing
* Installs Laravel dependencies
* Generates the application key
* Builds and starts all containers
* Runs migrations
* Automatically starts the scheduler and queue worker

The entire environment is ready without any manual setup.

---

# (Optional) Hosts Configuration

To make backend calls easier (especially from the frontend), it's recommended to add this entry to your `/etc/hosts`:

```
127.0.0.1 api.swapi.io swapi.io
```

To edit:

```bash
sudo nano /etc/hosts
```

---

# Important URLs

### Frontend (Vue)

```
http://localhost:5173
```

### Backend (Laravel)

```
http://localhost:8080
```

### API – SWAPI Proxy

```
GET /api/swapi/{resource}/{identifier?}
```

### Statistics Endpoints

```
GET /api/stats/average-request-time  
GET /api/stats/most-popular-hour  
```

---

# Useful Scripts

All scripts are located in the project root.

### Start everything

```bash
./start.sh
```

### Stop containers

```bash
./stop.sh
```

### Full rebuild (clean + rebuild + install dependencies)

```bash
./rebuild.sh
```

### Logs

```bash
./logs.sh php
./logs.sh queue
./logs.sh scheduler
```

---

# Container Architecture

```
docker-compose.yml
├── php           → Laravel backend (PHP-FPM)
├── nginx         → Web server
├── frontend      → Vue 3 + Vite
├── mysql         → Database
├── redis         → Queues / cache
├── scheduler     → Runs schedule:run
└── queue         → Runs queue:work
```

---

# Project Structure

```
/
├── api/               → Laravel backend
├── frontend/          → Vue frontend
├── docker/            → Dockerfiles
└── docker-compose.yml
```

---

# Running Tests (Laravel)

```bash
docker exec -it swapi-php php artisan test
```

---

# Automatic Statistics

A scheduled job runs every **5 minutes** to recalculate:

* average request time
* most popular hour
* total requests
* other metrics as needed

Implemented using Redis, events, queues, and scheduler.

---

# Machine Monitor System

A real-time factory floor monitoring application built with Laravel that demonstrates the Observer design pattern, WebSocket broadcasting, and live dashboard updates.

## Overview

This application simulates a factory production environment where machines can be in different states (PRODUCING, IDLE, STARVED) and provides real-time monitoring capabilities. Employees and dashboards are notified immediately when machine states change through the Observer pattern implementation.

## Features

- **Real-time Machine Monitoring**: Live tracking of machine states with WebSocket updates
- **Observer Pattern Implementation**: Clean separation between subjects (machines) and observers (employees, dashboards)
- **Audit Logging**: Complete history of all state changes stored in database
- **Live Dashboard**: Web-based interface showing current machine status with color-coded states
- **Console Simulation**: Command-line tool to simulate production floor activity
- **Laravel Reverb**: Real-time broadcasting using Laravel's official WebSocket server

## Architecture

### Design Patterns
- **Observer Pattern**: Machines notify multiple observers (employees, dashboard) of state changes
- **State Pattern**: Machines maintain different operational states with associated colors

### Key Components

- `Machine` (Subject): Represents factory machines that can change states
- `Employee` (Observer): Factory workers who get notified of machine changes
- `Dashboard` (Observer): Web interface that displays live machine status
- `MachineState` (Enum): Defines possible machine states with colors
- `MachineAuditLog`: Tracks all historical state changes

## Setup Instructions

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Build Assets**
   ```bash
   npm run build
   ```

5. **Run Tests**
   ```bash
   php artisan test
   ```

6. **Start the Application**
   ```bash
   # Start the web server
   php artisan serve

   # In another terminal, start the WebSocket server
   php artisan reverb:start

   # In another terminal, start the simulation
   php artisan app:start-production
   ```

## Usage

1. Visit `http://localhost:8000` to see the live dashboard
2. Run `php artisan app:start-production` to start the production simulation
3. Machines will randomly change states every 4 seconds
4. Watch real-time updates on both console and web dashboard

## Code Structure

```
app/
├── Console/Commands/StartProduction.php    # Main simulation command
├── Enum/MachineState.php                   # Machine state definitions
├── Events/MachineStateUpdated.php          # Broadcasting event
├── Models/
│   ├── Machine.php                         # Machine Eloquent model
│   ├── MachineAuditLog.php                 # Audit log model
│   └── Employee.php                        # Employee model
└── Production/                             # Domain logic
    ├── Machine.php                         # Machine subject
    ├── Employee.php                        # Employee observer
    ├── Dashboard.php                       # Dashboard observer
    ├── Subject.php                         # Observer pattern base
    └── Observer.php                        # Observer interface

database/
├── migrations/                             # Database schema
└── seeders/                                # Test data

resources/views/dashboard.blade.php         # Frontend dashboard

tests/
├── TestCase.php                            # Base test case configuration
├── Feature/
│   └── StartProductionTest.php             # Feature tests for observer pattern

```

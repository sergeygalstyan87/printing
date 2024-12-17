# **YansPrint**
**Customized Printing Management Software**

YansPrint is a software solution built with the Laravel framework. It streamlines client management, document handling, and workflows for printing services.

---

## **Features**
1. [x] Custom printing workflow management
2. [x] **Invoice Generation** and automatic email sending
3. [x] **Trello API** for task and workflow integration
4. [x] **Stripe Terminal** for secure payments
5. [x] **Shipping API** for order fulfillment and tracking
6. [x] **Google Drive Integration** for cloud file storage

---

## **Localhost Installation with Docker**

### **Pre-requisites**
1. Install **Docker** and **Docker Compose**:
    - **Linux**:
      ```bash
      sudo apt-get update
      sudo apt-get install docker docker-compose
      ```

2. Clone the repository:
   ```bash
   git clone https://github.com/sergeygalstyan87/printing.git
   cd printing
   ```
   
3. Create .env file:
   ```bash
   cp .env.example .env
   ```
   
4. Start Docker containers:
   ```bash
   docker-compose up -d
   ```

5. Install Composer dependencies:
   ```bash
   docker-compose exec app composer install
   ```

6. Generate the application encryption key:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

7. Verify ownership (optional for permissions):
   ```bash
   sudo chown -R www-data:www-data .
   ```

8. Access the application at http://localhost (default port 80).

## Environments

### Production
- **URL**: [https://demo.yansprint.com/](https://demo.yansprint.com/)
- **Folder Path**: `public_html/test/`
- **Database**: `u338590880_live`
- **Repo Branch**: `main`

## **Deployment Steps**

1. Pull the latest code:
   ```bash
   git pull origin main
   ```
   
2. Run optimization commands:
   ```bash
   php artisan optimize
   php artisan cache:clear
   ```

## **Integrations**

### **Trello API**
Integrate with Trello to manage tasks and workflows for print projects.

### **Stripe Terminal**
Process payments securely using Stripe Terminal for POS.

### **Shipping API**
Integrate with shipping providers for order fulfillment and tracking.

### **Google Drive Integration**
Save and retrieve files on Google Drive.

## **Code Repository**

Repository URL: [https://github.com/sergeygalstyan87/printing.git](https://github.com/sergeygalstyan87/printing.git)







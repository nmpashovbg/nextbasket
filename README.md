# Nextbasket Task

We've got two microservices
1. Users
2. Notifications

## Users Microservice Installation

1. **Clone the Repository:**
git clone <repository_url>

2. **Navigate to Users Microservice:**
cd users

3. **Create Environment File:**
cp .env.example .env

4. **Edit .env File:**
Open the `.env` file with your favorite editor and set the values for `RABBITMQ_USER` and `RABBITMQ_PASSWORD`.

        Example:  
      
        RABBITMQ_DEFAULT_USER=username  
        RABBITMQ_DEFAULT_PASS=password  
        RABBITMQ_USER=username  
        RABBITMQ_PASSWORD=password  

5. **Start the Microservice:**
./vendor/bin/sail up


## Notifications Microservice Installation

1. **Navigate to Notifications Microservice:**
cd notifications

2. **Create Environment File:**
cp .env.example .env

3. **Edit .env File:**
Open the `.env` file with your favorite editor and set the values for `RABBITMQ_USER` and `RABBITMQ_PASSWORD`.

        Example:  
        
        RABBITMQ_USER=username  
        RABBITMQ_PASSWORD=password  

4. **Start the Microservice:**
./vendor/bin/sail up

## RabbitMQ Command Listener

Once the Docker containers are up and running, you can enable the RabbitMQ command listener for the Notifications microservice. Run the following command within the `notifications` folder:
php artisan rabbitmq:consumer

This will start the command listener and allow the Notifications microservice to communicate with RabbitMQ.

Now both microservices are set up and ready to be used.



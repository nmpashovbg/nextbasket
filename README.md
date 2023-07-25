# Nextbasket Task

We've got two microservices
1. Users
2. Notifications

## Users Microservice Installation

1. **Clone the Repository:**
        ```git clone https://github.com/nmpashovbg/nextbasket.git```

2. **Navigate to Users Microservice:**
        ```cd users```

3. **Create Environment File:**
        ```cp .env.example .env```

4. **Edit .env File:**
Open the `.env` file with your favorite editor and set the values for `RABBITMQ_USER` and `RABBITMQ_PASSWORD`.

        Example:  
      
        RABBITMQ_DEFAULT_USER=username  
        RABBITMQ_DEFAULT_PASS=password  
        RABBITMQ_USER=username  
        RABBITMQ_PASSWORD=password  

5. **Run next command:**   ```composer install```
   
6. **Start the Microservice:**
        ```./vendor/bin/sail up```


## Notifications Microservice Installation

1. **Navigate to Notifications Microservice:**
        ```cd notifications```

2. **Create Environment File:**
        ```cp .env.example .env```

3. **Edit .env File:**
Open the `.env` file with your favorite editor and set the values for `RABBITMQ_USER` and `RABBITMQ_PASSWORD`.

        Example:  
        
        RABBITMQ_USER=username  
        RABBITMQ_PASSWORD=password

5. **Run next command:**   ```composer install```

6. **Start the Microservice:**
        ```./vendor/bin/sail up```

## RabbitMQ Command Listener

Once the Docker containers are up and running, you can enable the RabbitMQ command listener for the Notifications microservice. Run the following command within the `notifications` folder:
        ```php artisan rabbitmq:consumer```

This will start the command listener and allow the Notifications microservice to communicate with RabbitMQ.

Now both microservices are set up and ready to be used.


## Using Postman to Create a New User

1. **URL:** Open Postman and hit the following URL with a POST request:

        URL: http://localhost:8989/api/users
        Body: {"email": "npashov@gmail.com","firstName": "Nikola","lastName": "Pashov"}

![Screenshot 2023-07-25 at 20 45 29](https://github.com/nmpashovbg/nextbasket/assets/140022499/a4b2e6d7-260f-4b8c-ab60-413dcbc0bc23)


## How to run the tests?

1.  Navigate to the users or notification project and run next command:

         php artisan test

![Screenshot 2023-07-25 at 20 44 15](https://github.com/nmpashovbg/nextbasket/assets/140022499/4fb4f9d9-eb17-4656-8a9f-b7e40c475d57)

![Screenshot 2023-07-25 at 20 44 45](https://github.com/nmpashovbg/nextbasket/assets/140022499/bd35e108-674b-47c7-a470-304725349d9e)


pipeline {
    agent any

    environment {
        // Define environment variables if needed
        PHP_HOME = '/usr/bin/php' // Path to PHP installation
    }

    stages {
        stage('Checkout Code') {
            steps {
                echo 'Pulling code from repository...'
                checkout scm
            }
        }

        stage('Install Dependencies') {
            steps {
                echo 'Installing necessary dependencies...'
                sh 'sudo apt-get update'
                sh 'sudo apt-get install -y php-cli php-mysql composer'

                // If the project uses Composer for PHP dependencies
                sh 'composer install'
            }
        }

        stage('Setup Database') {
            steps {
                echo 'Setting up the database...'
                // Example: Run SQL migrations or create necessary tables
                sh 'mysql -u root -e "CREATE DATABASE IF NOT EXISTS online_voting;"'
                sh 'mysql -u root online_voting < db/schema.sql'
            }
        }

        stage('Run Tests') {
            steps {
                echo 'Running tests...'

                // Run PHP unit tests (ensure PHPUnit is installed)
                sh 'vendor/bin/phpunit tests/'
            }
        }
    }

    post {
        always {
            echo 'Cleaning up workspace...'
            cleanWs()
        }
        success {
            echo 'Build and tests succeeded!'
        }
        failure {
            echo 'Build or tests failed. Please check the logs.'
        }
    }
}

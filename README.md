# GitHub Workflow Example

This project showcasing GitHub Actions workflows for PHP Applications.

## Local Prerequisites

- Docker and Docker Compose installed on your machine
- A GitHub account with access to GitHub Container Registry (ghcr.io)
- Appropriate permissions to push to ghcr.io

## Setup

1. Clone this repository:
   ```
   git clone https://github.com/davchs/github-workflow-example.git
   cd github-workflow-example
   ```

2. Log in to GitHub Container Registry:
   ```
   docker login ghcr.io
   ```
   You'll be prompted to enter your GitHub username and a Personal Access Token with the necessary permissions.

3. Start the Docker services:
   ```
   docker compose up -d
   ```
4. Install PHP dependencies and set up the application:
   ```
   docker compose run --rm cli \
        composer install && \
        npm install && \
        bin/console doctrine:migrations:migrate
   ```
5. Restart the app services:
   ```
   docker compose restart app
   ```
6. Access the application at [http://localhost:8383](http://localhost:8383)

## Project Structure

- `docker-compose.yml`: Defines the services for the application
- `docker/php/Dockerfile`: Defines the PHP images (both app and CLI)
- `docker/bin/build.sh`: Script for building and pushing multi-arch Docker images

## Building and Pushing Images

The `build.sh` script in the `docker/bin/` directory is used to build multi-architecture Docker images (amd64 and arm64)
and optionally push them to GitHub Container Registry.

Before running the script, ensure you're logged in to ghcr.io (see Setup step 2).

To use the script:

1. To build images without pushing:
   ```
   docker compose up -d --build
   ```

2. To build images and push to ghcr.io:
   ```
   ./.docker/bin/push.sh
   ```

## Development

- The application code should be placed in the project root.
- Use `docker compose exec app` to run commands in the app container.
- Use `docker compose run --rm cli` to run commands in the CLI container.

## Services

- `app`: The main application container
- `cli`: A CLI container for running command-line tasks
- `database`: PostgreSQL database service
- `selenium`: Selenium service for running browser tests

## Additional Notes

- The PHP containers include Xdebug for debugging. Configure your IDE to use port 9000 for Xdebug.
- PostgreSQL data is persisted in a Docker volume.

## GitHub Actions

This project includes GitHub Actions workflows for:

- Running static analysis
- Running tests
- Deploying to different environments

Check the `.github/workflows/` directory for the specific workflow configurations.

## About the Author

This project is maintained by [davchs](https://www.linkedin.com/in/davchs). If you have any questions, feel free to
reach out via [GitHub](https://github.com/davchs) or [LinkedIn](https://www.linkedin.com/in/davchs).

## License

This project is open source and available under the [MIT License](LICENSE).
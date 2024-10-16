# GitHub Actions Example

This project showcases GitHub Actions workflows for PHP Applications.

## GitHub Actions Workflows

This project includes workflows for:

- Running static analysis
- Running tests
- Deploying to different environments

Check the `.github/workflows/` directory for specific workflow configurations.

## Additional Resources

- [GitHub Actions Workflow Syntax Documentation](https://docs.github.com/en/actions/writing-workflows/workflow-syntax-for-github-actions)
- [Store information in variables](https://docs.github.com/en/actions/writing-workflows/choosing-what-your-workflow-does/store-information-in-variables)
- [Accessing contextual information about workflow runs](https://docs.github.com/en/actions/writing-workflows/choosing-what-your-workflow-does/accessing-contextual-information-about-workflow-runs)
- [Controlling permissions for GITHUB_TOKEN](https://docs.github.com/en/actions/writing-workflows/choosing-what-your-workflow-does/controlling-permissions-for-github_token)
- [Managing GitHub Actions settings for a repository](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/enabling-features-for-your-repository/managing-github-actions-settings-for-a-repository)
- [Managing environments for deployment](https://docs.github.com/en/actions/managing-workflow-runs-and-deployments/managing-deployments/managing-environments-for-deployment)
- [Using environments for deployment](https://docs.github.com/en/actions/writing-workflows/choosing-what-your-workflow-does/using-environments-for-deployment)
- [Deploying with GitHub Actions](https://docs.github.com/en/actions/use-cases-and-examples/deploying/deploying-with-github-actions)
- [Debugging Actions with SSH](https://github.com/marketplace/actions/debugging-with-ssh)

Local Runners:
- [Docker Github Actions Runner](https://github.com/myoung34/docker-github-actions-runner)
- [act](https://github.com/nektos/act)

## Local Prerequisites

- Docker and Docker Compose installed
- GitHub account with access to GitHub Container Registry (ghcr.io)
- Appropriate permissions to push to ghcr.io

## Setup

1. Clone this repository:
   ```
   git clone https://github.com/davchs/github-actions-example.git
   cd github-actions-example
   ```

2. Log in to GitHub Container Registry:
   ```
   docker login ghcr.io
   ```
   Enter your GitHub username and a Personal Access Token with the necessary permissions.

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

5. Access the application at [http://localhost:8383](http://localhost:8383)
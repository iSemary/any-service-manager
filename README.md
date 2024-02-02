# Any Service Manager

Simplify Linux package management with this PHP and Twig engine. Install, uninstall, and check the status of popular packages like NPM, Redis, ElasticSearch, and more. Streamlined command-line interface for effortless package management on Linux systems.

## Features

- Install, uninstall, and check the status of packages on Linux.
- Editing PHP.ini files using forms.
- Support for popular packages like NPM, Redis, ElasticSearch, etc.
- Easy-to-use dashboard interface using Twig with AdminLTE 3.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Supported Packages](#supported-packages)
- [Contributing](#contributing)

## Installation

### Requirements

- PHP 8.2 or higher
- Composer installed

1. Clone the repository:

   ```bash
   git clone https://github.com/iSemary/any-service-manager.git
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

## Usage

1. Run the tool:

   ```bash
   php -S localhost:8000
   ```

2. Follow the on-screen instructions to manage packages.

## Supported Packages

- NPM
- Redis
- ElasticSearch
- MongoDB
- PM2
- Python
- Ruby
- Supervisor

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository.
2. Create a new branch: `git checkout -b feature/your-feature`.
3. Make your changes and commit them: `git commit -m 'Add some feature'`.
4. Push to the branch: `git push origin feature/your-feature`.
5. Submit a pull request.

# Group 15's Personal Contact Manager
A LAMP stack project.

## Members of Group 15
- Alyssa
- Amos
- Foutch
- Ilarya


## Using compose.yml to Scaffold the Project
1. Make sure Docker is installed on your system.
2. Navigate into the project repository: `cd lamp-stack-group-15`
3. Build the compose image (you only need to do this once): `docker compose build`
3. Start the project: `docker compose up`

### Accessing the project
- Frontend (Web App): Open your browser and go to http://localhost
- Database (phpMyAdmin): Visit http://localhost:8001

### phpMyAdmin Credentials
The credentials for phpMyAdmin are already set up in the compose.yml file:
- Username: group15
- Password: password
- Database name: lamp-stack-group-15


## Collaboration Workflow (Git & Forking Guide)

1. **Fork the repo** on GitHub.
2. **Clone your fork** and then add the original repo as the upstream.
```bash
git clone https://github.com/<your-github-name>/lamp-stack-group-15.git
cd lamp-stack-group-15
git remote add upstream https://github.com/amosperez/lamp-stack-group-15.
git fetch upsteam
```

3. Start work on your assigned task and files. 

Always start from the latest upstream/main.
```bash
git checkout main
git pull upstream main
git checkout -b <your-task-branch-name>
```

Only work on your assigned task and files to avoid complications with merging, and when done, add, commit, and push to your branch.
```bash
git add <your files>
git commit -m "Scope and summary"
git push -u origin 
```

Before merging with upstream/main (original repo), fetch the upstream for any possible changes already merged.
```bash
git fetch upstream
git checkout <your-task-branch-name>
git merge upstream/main
git push
```
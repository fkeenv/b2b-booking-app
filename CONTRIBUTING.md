## 🛠 Development Workflow

This section outlines the development lifecycle for contributing to this project. Please follow the steps below to ensure consistency and maintain code quality.

### ✅ Step-by-Step Guide

1. **Check Issue / Task**
   - Review the [Issues](../../issues) or the project board to find a task.
   - Assign the issue to yourself if you're starting work on it.
   - Clarify any missing details before proceeding.

2. **Create a Branch**
   - Create a new branch for the task/issue you're working on (on the lower right corner, under the Development, click on "Create a branch" anchor then click on Create branch. It should automatically create a branch for you).
   - Example:
     - `123-issue-description-or-title`

3. **Sync with the `main` Branch**
   - Before starting development, ensure your local `main` is up to date:
     ```bash
     git fetch origin
     git checkout main
     git pull
     ```
   - Merge `main` into your feature branch if needed:
     ```bash
     git checkout feature/issue-123-add-login
     git merge main
     ```

4. **Code and Develop**
   - Write your code and follow any existing coding standards.
   - Commit early and often with clear, concise commit messages.
   - If the task is too large, **break it down into smaller, manageable subtasks** and tackle them incrementally.

5. **Update Branch if Needed**
   - If `main` has changed during your development, re-sync and merge again as in step 3.
   - Always resolve conflicts locally and use descriptive merge commit messages:
     ```bash
     git merge main -m "Merge main into feature/issue-123-add-login"
     ```

6. **Commit and Push**
   - Stage your changes, commit them, and push to your fork or the origin repo:
     ```bash
     git add .
     git commit -m "Add login feature for issue #123"
     git push origin feature/issue-123-add-login
     ```

7. **Create a Pull Request (PR)**
   - Go to the GitHub repository and open a PR targeting the `main` branch.
   - Link the related issue (e.g., “Closes #123”) and provide a summary of your changes.

8. **Review and Merge**
   - Wait for review by a maintainer or collaborator.
   - Make any requested changes.
   - Once approved, your PR will be merged into `main`.

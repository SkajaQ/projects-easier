![Gluten Status](https://img.shields.io/badge/Gluten-Free-green.svg)
![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)

# Project Managing app for Teachers

### Practical task

"Project Manager" is a tiny CRUD application which allows to manage Students in Projects and their Groups.

## Project features

- technologies used: PHP Symfony, Bootstrap, CSS, JS Axios
- data persisted in mariaDB

## Technical solution

- Projects relate to Groups and Students as "OneToMany" also Groups relate to Students as "OneToMany"
- Groups are automatically created and persisted on Project Creation
- Students have unique full name (constraint in DB), students can be assigned only to one group 
- Creating a student adds it only to that one needed project automatically
- REST API for Student assigning to group provided (called via JS)
- Orphan removal 

## Authors

[Mazena](https://github.com/SkajaQ)
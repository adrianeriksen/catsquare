# Catsquare

Yet another stupid hobby project. This application is intended for square cat pictures.

The rationale is simple: learn and finish! How? By building a project from scratch, in a language I haven't used professionally and where it's easy to make mistakes. The definition of done is when it's uploaded to a server.

Mistakes were made, and this code is not secure.

## Getting Started

To get started, move into the `src` directory and provision the database with the following commands:

```
touch database.sqlite
sqlite3 database.sqlite < ../schema.sql
```

You should also open the database and add the first user manually. Go figure!

Once that's done, the application is ready. The next step is to FTP the files to the target server and enjoy the app. This is PHP at its best — low barrier to entry and mistakes.

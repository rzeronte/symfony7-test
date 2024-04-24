# Symfony Docker

```
mkdir symfony7-test
cd symfony7-test
git clone https://github.com/rzeronte/symfony7-test.git .
make build
make up
sleep 10 
make reset-db
make test
make coverage
make php-cs-fixer
make phpstan
```



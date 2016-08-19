### Fire VM up

```
cd homestead
vagrant up
(senha para shared folder)
```

### Set up host configuration

```
echo "5.5.5.5   phpsp-ima.dev" | sudo tee -a /etc/hosts
```

### migration
```
vagrant ssh 
cd demo-phpsp-ima/src/ 
php artisan migrate
exit
```

### open browser
```
open http://phpsp-ima.dev

```
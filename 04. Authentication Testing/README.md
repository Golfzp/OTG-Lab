<h4 align="center">OTG-Lab - CTF Lab follow OWASP Testing Guide v4</h4>

## 4. Authentication Testing

### Challenge Order:

#### Lab-I

Target of this lab is on follows URLs:

* http://[DockerIP]:52041   

This lab has 1 flags as follows topic:

- Default Credentials

#### Lab-II

Target of this lab is on follows URLs:

* http://[DockerIP]:52042

This lab has 1 flags as follows topic:

- Weak lock out mechanism
- Bypassing authentication schema
- Weak password policy

### Start the labs

```bash
$ cd OTG-Lab
$ cd "04. Authentication Testing"
$ cd docker
$ docker-compose up -d
```

### Stop the labs

```bash
$ cd OTG-Lab
$ cd "04. Authentication Testing"
$ cd docker
$ docker-compose rm -f -s
```


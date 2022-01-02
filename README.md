# Instalacion de django limpia con soporte de docker
Se debe tener los archivos basicos para docker y dockercompose que permitan instalar las apps
necesarias:

Los archivos minimos son:
- docker-compose.yml --> Documento con informacion de configuracion necesaria para el funcionamiento de docker.
- Dockerfile --> Indicaciones para docker (comandos) necesarios para el ambiente docker
- requirements.txt --> Aqui se deben listar todos los componentes necesarios para la aplicacion.

Para implementar django dentro de la carpeta se debe ejecutar el siguiente comando:
- sudo docker-compose run web django-admin startproject [nombre_del_proyecto] .

El proyecto se crea por el usuario root, por lo tanto hay que cambiar el dueno del directorio:
- sudo chown -R $USER:$USER .

Para instalar los componentes que estan en el archivo requirement.txt.
- sudo docker-compose run web pip install -r requirements.txt

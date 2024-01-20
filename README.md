Fala galera,

Uma api proxy pra checkuser direct security.

exemplo de uso

https://subdominio.dominio/apiproxy.php?url=checkusergeradonavps

Só colocar na hospedagem, extrair e coloacar os ips no arquivo (ips.txt)

Caso queira proteger o arquivo ips.txt e .htaccess pra não ter leitura sem ser pelo server

Adicione essas linhas no .htaccess


```Options -Indexes
<files .htaccess>
order allow,deny
deny from all
satisfy all
</files>
<files ips.txt>
order allow,deny
deny from all
</files>```
Jeremy Lenoir
Thème : les chaises (parce que j'aime bien m'asseoir)
Nomemclature :
[Objet] : Chair
[Inventaire] : Stack
[Galerie] : Lounge


Chair : 
	-name
	-Description
	-Type (tabouret/fauteuil/chaise...)
	-Nombre de pieds
	-rareté (épic/légendaire/commun...)
	-chairToStack (realation ManyToOne vers stack)
	-manyToMany(relation ManyToMany vers Lounge)

Stack :
	-name
	-Description
	-visibilité (privée/publique)
	-liste de chaises
	-member 
	-chairsInStack (OneToMany vers Chair)

Lounge :
	-description
	-published
	-manytomany (vers chaise)
	-member (Many to One vers membre)

Member :
	-nom
	-description
	-OneToMany (vers stack)
	-lounges (OneToMany vers Lounge)
	-User (OneToOne vers User)

User :
	-email	
	-roles
	-password
	-member (OneToOne ver Member)

Explication : 
Pour la checklist de notation vous pouvez aller voir dans TODO où tout est détaillé.
Pour se connecter en tant que user essayez : aymeric@tryhard et mdp : tryhard ou louis@rust et mdp : rust
Pour se connecter en tant qu'admin (avec /admin) essayez : jeremy@bg et mdp : tryhard


Normalement l'ensemble du site est accessible par le menu de navigation, a l'exception d'Easy Admin où il faut taper /admin


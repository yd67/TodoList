
Afin de contribuer au projet veuillez respecter les éléments qui suit .




# Soumetre une issue

Vous pouvez soumettre une issue, en vérifiant au préalable bien entendu que celle-ci n'est pas déjà présente.

[explication](https://docs.github.com/fr/issues/tracking-your-work-with-issues/creating-an-issue)
# Proposer une pull request

L'ajout de nouvelle fonctionnalité se fait en créant une branche spécifique à une issue.Et par la suite vous pouvez proposer une pull request .

Avant de proposer une pull request le code doit respecter le **processus de qualité** . c'est a dire :

## Faire une analyse de son code 

le code doit au préalable avoir fait l'objet d'une analyse, avec un outils spécialisé telle que [Codacy](https://www.codacy.com) 

Pour Codacy la note doit etre superieur a **B** .


## Mettre en place des tests sur le projet

Pour l'ajout de toutes nouvelles fonctionnalité, des tests **unitaires** et **fonctionnelles** devront être mise en place .les tests devront  être implémenté avec **PhpUnit**.

se référer à la [documentation officielle de Symfony](https://symfony.com/doc/current/testing.html) 


il faudra faire en sorte que la couverture de code soit superireur a 88% .

Chemin couverture de code : public/test-coverage 

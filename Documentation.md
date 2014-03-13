Documentation d'utilisation du système de gestion de formation

I introduction

    Le système de gestion de formation se présente sous la forme d'une interface web qui communique avec une base de donnée. Quelque soit la donnée (utilisateur ou formation), il est possible en fonction des rôles du manipulateur de la consulter, la créer, la modifier ou la supprimer.
    Nous décrirons dans les parties suivantes comment est organisée l'interface et quelle manipulation elle permet en fonction des rôles attribués à chaque utilisateur.

II les utilisateurs
    
    Les utilisateurs sont rangé en plusieurs catégories. Voici leur descriptions ainsi que les actions qu'ils disposent au sein de l'interface :
    
		Administrateur : L'administrateur de l'interface dispose de l'intégralité des droits dans les manipulation des données. Il peut créer, modifier et supprimer les utilisateurs et les formations. C'est lui qui doit créer les profils des secrétaires de formations afin qu'ils prennent le relai pour les étudiants.
		
		Secrétaire pédagogique : Le secrétaire se voit allouer la gestion d'une ou plusieurs formations créées par l'administrateur. Il crée les profils étudiants correspondants à ses formations et les matières qu'ils étudieront. Il doit créer puis lier les matières à un cursus qui correspond à une année universitaire d'une formation.
		
		L'étudiant : Ce profil ne peut qu'accéder à la liste des matières constituants la formation où il est inscrit.
		
		L'anonyme : Cet utilisateur n'a aucun accès sur l'interface. Il est bloqué par une barrière d'authentification à chaque page.

III les formations
    
    L'entité formation est comprise comme étant un cursus finissant sur un diplôme. Elle dispose de l'intitulé dudit diplôme pour l'identifier ainsi qu'un description. En pratique, il est possible que chaque année son cursus de matière change. Aussi, chaque formation dispose d'un cursus par année universitaire. C'est ce dernier qui se voit associer des matières. Il faut en créé un pour chaque année où la formation a lieu. Seul l'administrateur peut les créer et les supprimer, mais le secrétaire pédagogique qui est associé peut les modifier au besoin.

    L'entité matière correspond à une matière enseignée durant une ou plusieurs formations. Elle peut être associée à autant de formations que possible et est rangée en thématique avec d'autres matières. L'administrateur et le secrétaire pédagogique peuvent tous les deux créer, modifier et associer des matières aux formations.
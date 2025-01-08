<?php

namespace client\traitements;

class Utilisateur
{
    private ?int $utilisateur_id = null;      // AUTO_INCREMENT
    private string $prenom;
    private string $nom;
    private string $niveau;
    private string $email;
    private ?string $mot_de_passe_hash;
    private ?string $photo;
    private ?string $date_creation = null;    // timestamp// référence vers Promotion
    private ?float $score_personnalite = null;
    private ?int $id_profil = null;

    /**
     * @param int|null $utilisateur_id
     * @param string $prenom
     * @param string $nom
     * @param string $niveau
     * @param string $email
     * @param string|null $mot_de_passe_hash
     * @param string|null $photo
     * @param string|null $date_creation
     * @param float|null $score_personnalite
     * @param int|null $id_profil
     */
    public function __construct(?int $utilisateur_id, string $prenom, string $nom, string $niveau, string $email, ?string $mot_de_passe_hash, ?string $photo, ?string $date_creation, ?float $score_personnalite, ?int $id_profil)
    {
        $this->utilisateur_id = $utilisateur_id;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->niveau = $niveau;
        $this->email = $email;
        $this->mot_de_passe_hash = $mot_de_passe_hash;
        $this->photo = $photo;
        $this->date_creation = $date_creation;
        $this->score_personnalite = $score_personnalite;
        $this->id_profil = $id_profil;
    }

    public function getUtilisateurId(): ?int
    {
        return $this->utilisateur_id;
    }

    public function setUtilisateurId(?int $utilisateur_id): void
    {
        $this->utilisateur_id = $utilisateur_id;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getNiveau(): string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): void
    {
        $this->niveau = $niveau;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getMotDePasseHash(): ?string
    {
        return $this->mot_de_passe_hash;
    }

    public function setMotDePasseHash(?string $mot_de_passe_hash): void
    {
        $this->mot_de_passe_hash = $mot_de_passe_hash;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    public function getDateCreation(): ?string
    {
        return $this->date_creation;
    }

    public function setDateCreation(?string $date_creation): void
    {
        $this->date_creation = $date_creation;
    }

    public function getScorePersonnalite(): ?float
    {
        return $this->score_personnalite;
    }

    public function setScorePersonnalite(?float $score_personnalite): void
    {
        $this->score_personnalite = $score_personnalite;
    }

    public function getIdProfil(): ?int
    {
        return $this->id_profil;
    }

    public function setIdProfil(?int $id_profil): void
    {
        $this->id_profil = $id_profil;
    }


}
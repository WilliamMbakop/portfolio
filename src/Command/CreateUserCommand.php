<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Cette commande permet de créer un utilisateur admin',
)]
class CreateUserCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Crée un utilisateur admin')
            ->setHelp('Cette commande vous permet de créer un utilisateur admin')
            ->addArgument('email', InputArgument::REQUIRED, "L'email de l'utilisateur");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Récupérer l'email
        $email = $input->getArgument('email');

        // Vérification du format de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $io->error("L'email $email n'est pas valide.");
            return Command::FAILURE;
        }

        // Vérification si l'email est déjà pris
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            $io->error("Un utilisateur avec l'email $email existe déjà.");
            return Command::FAILURE;
        }

        // Demander le mot de passe en masqué
        $plaintextPassword = $io->askHidden("Entrez le mot de passe de l'utilisateur (il sera masqué)");

        if (empty($plaintextPassword)) {
            $io->error("Le mot de passe ne peut pas être vide.");
            return Command::FAILURE;
        }

        try {
            // Création du nouvel utilisateur
            $user = new User();
            $user->setEmail($email);
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plaintextPassword);
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_ADMIN']);

            // Persist et flush en base
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $io->success("L'utilisateur $email a été créé avec succès !");
        } catch (\Exception $e) {
            $io->error("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}

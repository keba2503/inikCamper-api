<?php

namespace App\Controller\Admin;

use App\Entity\File;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileCrudController extends AbstractCrudController
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getEntityFqcn(): string
    {
        return File::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Files')
            ->setEntityLabelInSingular('File')
            ->setPageTitle('index', 'List of %entity_label_plural%')
            ->setPageTitle('new', 'Create %entity_label_singular%')
            ->setPageTitle('edit', 'Edit %entity_label_singular%');
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('uploadedAt')
            ->add('filename')
            ->add('title')
            ->add('description');
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateField::new('uploadedAt', 'Uploaded At')->setFormat('d/m/Y')->setFormTypeOptions(['html5' => true]);
        yield TextField::new('filename', 'Filename')->hideOnForm();
        yield TextField::new('title', 'Title');
        yield TextareaField::new('description', 'Description');

        $fileField = ImageField::new('filename', 'Upload File')
            ->setUploadDir('public/upload')
            ->setBasePath('/upload')
            ->setUploadedFileNamePattern('[randomhash].[extension]')
            ->setFormTypeOption('attr.accept', '*/*')
            ->setRequired(false);

        yield $fileField;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof File) {
            $this->handleFileUpload($entityInstance);
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof File) {
            $this->handleFileUpload($entityInstance);
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    private function handleFileUpload(File $file): void
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $file->getFilename();
        if ($uploadedFile instanceof UploadedFile) {
            $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/upload';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $this->slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

            try {
                $uploadedFile->move($uploadDirectory, $newFilename);
                $file->setFilename($newFilename);
                $file->setUploadedAt(new \DateTimeImmutable());
            } catch (FileException $e) {
                // Handle exception if something happens during file upload
                throw new \Exception('Failed to upload file: '.$e->getMessage());
            }
        }
    }

    #[Route('/file/download/{id}', name: 'file_download')]
    public function download(File $file): Response
    {
        $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/upload';
        $filePath = $uploadDirectory . '/' . $file->getFilename();

        return new BinaryFileResponse($filePath);
    }
}

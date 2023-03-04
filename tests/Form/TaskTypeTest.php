<?php

namespace Tests\Form;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'title' => 'le titre',
            'content' => 'le contenu',
        ];
        $model = new Task();
        $form = $this->factory->create(TaskType::class, $model);

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }
}

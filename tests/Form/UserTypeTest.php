<?php

namespace Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'username' => 'test98',
            'email' => 'test98@gmail;com',
            'password' => 'test',
            'roles' => []
        ];
        $model = new User();
        $form = $this->factory->create(UserType::class, $model);

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }
}

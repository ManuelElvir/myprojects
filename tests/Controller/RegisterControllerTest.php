<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;

class RegisterControllerTest extends WebTestCase
{

    public function testRegisterPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/register');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Sign up to My Projects');
        $this->assertSelectorTextContains('label[for="registration_form_email"]', 'Email');
        $this->assertSelectorTextContains('label[for="registration_form_password_first"]', 'Password');
        $this->assertSelectorTextContains('label[for="registration_form_password_second"]', 'Confirm Password');
        $this->assertSelectorTextContains('label[for="registration_form_agreeTerms"]', 'I agree to the terms and conditions');
        $this->assertSelectorNotExists('form div ul li');
    }

    public function testRegisterRequireCsrf(): void
    {
        $client = static::createClient();
        
        $client->request('POST', '/register', [
            'registration_form[email]'=>'testb1@test.com',
            'registration_form[password][first]'=>'P@ssword23',
            'registration_form[password][second]'=>'P@ssword23',
            'registration_form[agreeTerms]'=>'1',
            'registration_form[_token]'=>'token',
        ]);
        $this->assertSelectorTextContains('h2', 'Sign up to My Projects');
    }

    public function testRegisterValidation(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Sign up')->form([
            'registration_form[email]'=>'not_valid_email',
            'registration_form[password][first]'=>'not_valid_password',
            'registration_form[password][second]'=>'not_same_password',
        ], method: 'POST');
        $client->submit($form);
        
        $this->assertSelectorTextContains('h2', 'Sign');
        $this->assertSelectorCount(3, 'form div ul li',);
    }

    public function testRegisterPasswordValidation(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Sign up')->form([
            'registration_form[email]'=>'testb2@test.com',
            'registration_form[password][first]'=>'simple_password',
            'registration_form[password][second]'=>'simple_password',
            'registration_form[agreeTerms]'=>'1',
        ], method: 'POST');
        $client->submit($form);

        $this->assertSelectorTextContains('h2', 'Sign');
        $this->assertSelectorTextContains('form div ul li', 'At least 8 characters with at least 1 uppercase letter, number, and special character.');
        $this->assertSelectorCount(1, 'form div ul li',);
    }

    public function testSuccessfulRegister(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Sign up')->form([
            'registration_form[email]'=>'testb3@test.com',
            'registration_form[password][first]'=>'P@ssword23',
            'registration_form[password][second]'=>'P@ssword23',
            'registration_form[agreeTerms]'=>'1',
        ], method: 'POST');
        $crawler = $client->submit($form);

        file_put_contents(__DIR__. '/response.html', $crawler->html());
        
        $this->assertResponseRedirects('/', expectedCode: 302);
    }

    public function testRegisterEmailValidation(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/register');
        $form = $crawler->selectButton('Sign up')->form([
            'registration_form[email]'=>'testb3@test.com',
            'registration_form[password][first]'=>'P@ssword23',
            'registration_form[password][second]'=>'P@ssword23',
            'registration_form[agreeTerms]'=>'1',
        ], method: 'POST');
        $client->submit($form);

        $this->assertSelectorTextContains('h2', 'Sign');
        $this->assertSelectorTextContains('form div ul li', 'There is already an account with this email');
        $this->assertSelectorCount(1, 'form div ul li',);
    }
}

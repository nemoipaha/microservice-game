<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $wallet;
    private $secretsCache;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->secretsCache = new SecretsCache();
        $this->wallet = new Wallet($this->secretsCache);
    }

    /**
     * @Given there is a(n) :arg1
     * @param string $secret
     */
    public function thereIsA(string $secret)
    {
        $this->secretsCache->setSecret($secret);
    }

    /**
     * @When I add the :secret to the wallet
     * @param $secret
     */
    public function iAddTheToTheWallet(string $secret)
    {
        $this->wallet->addSecret($secret);
    }

    /**
     * @Then I should have :count secret(s) in the wallet
     * @param int $count
     */
    public function iShouldHaveSecretInTheWallet(int $count)
    {
        Assert::assertCount($count, $this->wallet);
    }
}

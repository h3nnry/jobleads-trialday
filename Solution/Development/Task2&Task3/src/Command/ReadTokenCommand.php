<?php

namespace App\Command;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:read-token',
    description: 'Generate token for further use',
)]
class ReadTokenCommand extends Command
{
    public function __construct(private JWTTokenManagerInterface $JWTManager, private JWTEncoderInterface $jwtEncoder)
    {
        parent::__construct();
    }

    //    protected function configure()
    //    {
    //        $this->addArgument('stdin', InputArgument::OPTIONAL, 'Input data', null);
    //    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputSteam = ($input instanceof StreamableInputInterface) ? $input->getStream() : null;

        $inputSteam = $inputSteam ?? STDIN;

        $input = stream_get_contents($inputSteam);

        dump($this->jwtEncoder->decode($input));

        return Command::SUCCESS;
    }
}

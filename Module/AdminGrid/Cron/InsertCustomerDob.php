<?php

namespace Module\AdminGrid\Cron;

use Module\AdminGrid\Model\CustomRuleFactory;
use Magento\Customer\Model\Customer as CustomerRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Stdlib\DateTime\DateTime;

class InsertCustomerDob
{

    protected $CustomerData;
    protected $customerRepository;
    protected $date;
    protected $searchCriteria;

    public function __construct(
        CustomRuleFactory $CustomerData,
        CustomerRepository $customerRepository,
        DateTime $date,
        SearchCriteriaBuilder $searchCriteria
    ) {
        $this->CustomerData = $CustomerData;
        $this->customerRepository = $customerRepository;
        $this->date = $date;
        $this->searchCriteria = $searchCriteria;;
    }

    public function execute()
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/UpdateCustomeDob.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);

        $allCustomer = $this->customerRepository->getCollection()
            ->addAttributeToSelect("*")->load();

        foreach ($allCustomer as $customer) {

            $insert = $this->CustomerData->create();
            $insert->addData([
                'email' => $customer->getEmail(),
                'dob' => $customer->getDob(),
                'greeting_status' => 0,
            ]);

            $checks = $this->CustomerData->create()->getCollection();
            $Cemail=$customer->getEmail();
            $flag=true;
            foreach ($checks as $check) {
                if($check->getEmail()==$Cemail)
                    $flag=false;
            }
            if($flag)
                $insert->save();
        }
        $DOBcheck = $this->CustomerData->create()->getCollection();
        
        foreach($DOBcheck as $dob){
            if(date('m-d')==substr($dob->getDob(),-5)){
                $dob->setData('greeting_status',1);
                $logger->info(
                    "
                 __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __   
                |    
                |    Subject: Happy Birthday !                
                |    
                |    Dear {{$dob->getData('email')}},
                |    
                |    We hope this message finds you well.  
                |    We would like to take this opportunity
                |    to wish you a very happy birthday! On 
                |    this special day, we want to thank you    
                |    for your continued support and loyalty.   
                |    
                |    As a token of our appreciation,
                |    we are offering you a special 
                |    birthday discount of 50% on your
                |    next purchase with us. Use the 
                |    code 'BIRTHDAY' at checkout to 
                |    redeem your discount.
                |    
                |    We hope you have a wonderful day 
                |    filled with love and laughter.
                |    
                |    Warm regards,
                |    {{Magento Store}}
                |                   
                |__ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __ __   
                    "
                );
            $dob->save();
            }
        }
    }
}

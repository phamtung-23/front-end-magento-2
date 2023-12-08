<?php 
// File: app/code/Vendor/Module/Plugin/Breadcrumbs.php
namespace Unit1\Ex4\Plugin;

class Breadcrumbs
{
    public function beforeAddCrumb(\Magento\Theme\Block\Html\Breadcrumbs $subject, $crumbName, $crumbInfo)
    {
        // Transform every crumb name into "!"
        // dd($crumbInfo);
        $crumbInfo["label"] = ($crumbInfo["label"].' (!)');

        // Call the original addCrumb method with the modified crumb name
        return [$crumbName, $crumbInfo];
    }
}

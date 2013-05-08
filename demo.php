<?php
	include("summarizer.class.php");

ob_start();
?>
Organization:   Accenture Federal Services
Location:         Washington DC / Arlington, VA
Travel:             None
Accenture Federal Services, a wholly-owned subsidiary of Accenture, helps U.S.

federal agencies build the government of the future.  With 4,000 dedicated US employees, Accenture Federal Services is uniquely positioned to support federal agencies in shattering the status quo, achieving profound efficiencies and relentlessly delivering results.  Accenture Federal Services is a long-time and trusted resource for the federal community.

Every cabinet level agency in the United States-and 20 of the country's largest federal government agencies-have worked with Accenture Federal Services to achieve outcomes and move toward high performance.

Join us and you can help our federal clients achieve what matters most, powering the services that touch the nation every day.Job Description:Microsoft Dynamics CRM is a leading application for managing relationships and contact.

Our customers may use the application for traditional customer relationship management or they may be using it as a development platform to manage complex business priorities.

We work with the client to define the business process, develop a solution and support the customer's implementation of Dynamics CRM.  Our work includes the entire software development lifecycle for configuration, customization, and integration of Dynamics CRM.

We also include additional Microsoft technologies when they apply to the customer's needs.PRIMARY RESPONSIBILITIES: ¥ Interact with the customer and team to gain an understanding of the business environment, technical context and organizational strategic direction.

¥ Applies specialized knowledge in a solutions development discipline to conceptualize, design, construct, and implement systems that enable and support business functions.

¥ Confirm and prioritizes project plans and deliverables with the internal staff and customer.

¥ Work with delivery team to ensure deliverable's scope, timelines, and budget are met.

¥ Effectively applies development best practices to deliverables and upholds quality.
<?php
$content = ob_get_contents();
ob_end_clean();

    $st = new Summarizer();
    $summary = $st->get_summary($content);
	echo $summary;
	echo $st->how_we_did();


?>
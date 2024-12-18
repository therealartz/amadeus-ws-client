<?php

namespace Amadeus\Client\ResponseHandler\Ticket;

/**
 * HandlerList
 *
 * @package Amadeus\Client\ResponseHandler\Queue
 * @author Marius Marcu <marmaris1910@gmail.com>
 */
class HandlerList extends \Amadeus\Client\ResponseHandler\Queue\HandlerList
{
    /**
     * Returns the errortext from a Ticket_ProcessETicketReply errorcode
     *
     * This function is necessary because the core only responds
     * with errorcode but does not send an errortext.
     *
     * The errorcodes for all Queue_*Ticket_ProcessETicketReply messages are the same.
     *
     * @param string $errorCode
     * @return string the errortext for this errorcode.
     */
    protected function getErrorTextFromQueueErrorCode($errorCode)
    {
        $recognizedErrors = [
            '1' => 'Invalid date',
            '107' => 'Invalid Airline Designator/Vendor Supplier',
            '109' => 'Invalid Country Code',
            '111' => 'Invalid Agent\'s Code',
            '112' => 'Requestor Identification Required',
            '113' => 'Invalid Period of Operation',
            '114' => 'Invalid Flight Number',
            '115' => 'Invalid Arrival Date',
            '116' => 'Invalid Arrival Time',
            '118' => 'System Unable to Process',
            '12' => 'Invalid product details qualifier coded',
            '120' => 'Invalid Action Code',
            '129' => 'No PNR Match Found',
            '130' => 'Invalid Origin and Destination Pair',
            '134' => 'Advise Times Different from Booked',
            '135' => 'Advise Dates Different from Booked',
            '136' => 'Advise Class Different from Booked',
            '144' => 'Invalid Requestor Identification',
            '149' => 'Surname too Long',
            '151' => 'Surname Mandatory',
            '152' => 'Given Name/Title Mandatory',
            '153' => 'Name Mismatch',
            '154' => 'Message Function Invalid',
            '155' => 'Message Function Not Supported',
            '156' => 'Business Function Invalid',
            '157' => 'Business Function Not Supported',
            '159' => 'Phone Field Required',
            '18' => 'Invalid on-time performance indicator',
            '19' => 'Invalid type of call at port coded',
            '190' => 'Invalid Processing Indicator',
            '191' => 'Name Reference Required',
            '192' => 'Name Reference Inhibited',
            '193' => 'Segment Reference Required',
            '194' => 'Segment Reference Inhibited',
            '2' => 'Invalid time',
            '20' => 'Invalid government action coded',
            '21' => 'Invalid facility type coded',
            '22' => 'Invalid traffic restriction coded',
            '23' => 'Invalid traffic restriction type coded',
            '24' => 'Invalid traffic restriction qualifier coded',
            '244' => 'Not allowed on marketing flights',
            '245' => 'Please request on operating carrier',
            '25' => 'Invalid transport stage qualifier coded',
            '259' => 'Invalid Combination of Generic Codes',
            '260' => 'Invalid Frequent Traveler Number',
            '266' => 'Limited Recline Seat has been Reserved',
            '267' => 'Name in the Request Does Not Match Name in Reservation',
            '268' => 'Need Names, Passenger Name Information Required to Reserve Seats',
            '269' => 'Indicates that Additional Data for this Message Reference Number follows',
            '288' => 'Unable to Satisfy, Need Confirmed Flight Status',
            '289' => 'Unable to Retrieve PNR, Database Error',
            '294' => 'Invalid Format',
            '295' => 'No Flights Requested',
            '3' => 'Invalid transfer sequence',
            '301' => 'Application Suspended',
            '302' => 'Invalid Length',
            '304' => 'System Temporarily Unavailable',
            '305' => 'Security/Audit Failure',
            '306' => 'Invalid Language Code',
            '307' => 'Received from data missing',
            '308' => 'Received from data invalid',
            '309' => 'Received from data missing or invalid',
            '310' => 'Ticket arrangement data missing',
            '311' => 'Ticket arrangement data invalid',
            '312' => 'Ticket arrangement data missing or invalid',
            '320' => 'Invalid segment status',
            '321' => 'Duplicate flight segment',
            '325' => 'Related system reference error',
            '326' => 'Sending system reference error',
            '327' => 'Invalid segment data in itinerary',
            '328' => 'Invalid aircraft registration',
            '329' => 'Invalid hold version',
            '330' => 'invalid loading type',
            '331' => 'Invalid ULD type',
            '332' => 'Invalid serial number',
            '333' => 'Invalid contour/height code',
            '334' => 'Invalid tare weight',
            '335' => 'Unit code unknown',
            '336' => 'Invalid category code',
            '337' => 'Invalid special load reference',
            '338' => 'Invalid weight status',
            '347' => 'Incompatible loads',
            '348' => 'Invalid flight status',
            '349' => 'Invalid application/product identification',
            '352' => 'Link to inventory system is unavailable',
            '354' => 'Invalid product status',
            '356' => 'Query control tables full',
            '357' => 'Declined to process interactively-default to backup',
            '360' => 'Invalid PNR file address',
            '361' => 'PNR is secured',
            '362' => 'Unable to display PNR and/or name list',
            '363' => 'PNR too long',
            '364' => 'Invalid ticket number',
            '365' => 'Invalid responding system in-house code',
            '366' => 'Name list too long',
            '367' => 'No active itinerary',
            '368' => 'Not authorized',
            '369' => 'No PNR is active, redisplay PNR required',
            '370' => 'Simultaneous changes to PNR',
            '371' => 'Prior PNR display required',
            '375' => 'Requestor not authorized for this function for this PNR',
            '381' => 'Record locator required',
            '382' => 'PNR status value not equal',
            '383' => 'Invalid change to status code',
            '384' => 'Multiple Name Matches',
            '385' => 'Mutually exclusive optional parameters',
            '386' => 'Invalid minimum/maximum connect time specified',
            '390' => 'Unable to reformat',
            '391' => 'PNR contains non air segments',
            '392' => 'Invalid block type/name',
            '393' => 'Block sell restricted-request block name change',
            '394' => 'Segment not valid for electronic ticketing',
            '395' => 'Already ticketed',
            '396' => 'Invalid ticket/coupon status',
            '397' => 'Maximum ticket limit reached',
            '399' => 'Duplicate Name',
            '4' => 'Invalid city/airport code',
            '400' => 'Duplicate ticket number',
            '401' => 'Ticket number not found',
            '403' => 'Requested Data Not Sorted',
            '408' => 'No More Data Available',
            '414' => 'Need Prior Availability Request',
            '415' => 'Need Prior Schedule Request',
            '416' => 'Need Prior Timetable Request',
            '417' => 'Repeat Request Updating in Progress',
            '437' => 'Carrier must be in separate PNR',
            '438' => 'Request is outside system date range for this carrier within this system',
            '440' => 'Void request on already voided or printed coupons',
            '441' => 'Invalid Priority Number',
            '442' => 'System in control of device is unknown',
            '443' => 'Device address is unknown',
            '445' => 'Security indicator requires originator ID',
            '448' => 'Contact Service Provider directly',
            '450' => 'All electronic ticket coupons have been printed',
            '451' => 'Only individual seat request allowed at this time',
            '457' => 'Unable-Connection Market Unavailable',
            '459' => 'Owner Equal to Requestor',
            '462' => 'Invalid authorization number',
            '463' => 'Authorization number already used',
            '466' => 'Form of payment missing or invalid for electronic ticketing',
            '472' => 'Account does not allow redemption',
            '473' => 'No award inventory available for requested market and date',
            '5' => 'Invalid time mode',
            '6' => 'Invalid operational suffix',
            '7' => 'Invalid period of schedule validity',
            '705' => 'Invalid or missing Coupon/Booklet Number',
            '706' => 'Invalid Certificate Number',
            '708' => 'Incorrect credit card information',
            '709' => 'Invalid and/or missing frequent traveler information',
            '70D' => 'Display criteria not supported',
            '710' => 'Free text qualifier error',
            '711' => 'Invalid Fare Calculation Status Code',
            '712' => 'Missing and/or invalid monetary information',
            '713' => 'Invalid Price Type Qualifier',
            '716' => 'Missing and/or invalid reservation control information',
            '717' => 'Missing and/or invalid travel agent and/or system identification',
            '718' => 'Invalid Document Type',
            '721' => 'Too much data',
            '723' => 'Invalid category',
            '724' => 'Invalid routing',
            '725' => 'Domestic itinerary',
            '726' => 'Invalid global indicator',
            '727' => 'Invalid amount',
            '728' => 'Invalid conversion type',
            '729' => 'Invalid currency code',
            '738' => 'Overflow',
            '743' => 'Electronic ticket record purposely not accessable',
            '745' => 'Refund (full or partial) not allowed',
            '746' => 'Open segment(s) not permitted for first coupon or entire itinerary',
            '747' => 'Validity date(s) required for electronic tickets',
            '748' => 'Status change denied',
            '749' => 'Coupon status not open',
            '750' => 'Endorsement restriction',
            '754' => 'Electronic ticket outside validity date',
            '755' => 'Invalid exchange/coupon media',
            '757' => 'Exchange paper to electronic ticket not allowed',
            '760' => 'Conjunction ticket numbers are not sequential',
            '761' => 'Exchange/Reissue must include all unused coupons',
            '762' => 'Invalid tax amount',
            '763' => 'Invalid tax code',
            '766' => 'Ticket has no residual value',
            '767' => 'Historical data not available - unable to process',
            '790' => 'Exchange denied - no further exchanges allowed',
            '791' => 'Unable to void exchanged/reissued ticket',
            '792' => 'Segment not eligible for interline electronic ticket',
            '793' => 'Fare/tax amount too long',
            '794' => 'Invalid or missing fare calculation',
            '795' => 'Invalid, missing or conflicting search criteria',
            '796' => 'Partial void of ticket coupons not allowed',
            '797' => 'Invalid stopover indicator',
            '798' => 'Invalid stopover code usage',
            '799' => 'Electronic ticket exists, no match on specified criteria',
            '79A' => 'Invalid office identification',
            '8' => 'Invalid days of operation',
            '9' => 'Invalid frequency rate',
            '900' => 'Inactivity Time Out Value Exceeded',
            '901' => 'Communications Line Unavailable',
            '902' => 'Prior message being processed or already processed',
            '911' => 'Unable to process - system error',
            '912' => 'Incomplete message - data missing in query',
            '913' => 'Item/data not found or data not existing in processing host',
            '914' => 'Invalid format/data - data does not match EDIFACT rules',
            '915' => 'No action - processing host cannot support function',
            '916' => 'EDIFACT version not supported',
            '917' => 'EDIFACT message size exceeded',

        ];

        $errorMessage = (array_key_exists($errorCode, $recognizedErrors)) ? $recognizedErrors[$errorCode] : '';

        if ($errorMessage === '') {
            $errorMessage = "PROCESS E-TICKET ERROR '" . $errorCode . "' (Error message unavailable)";
        }

        return $errorMessage;
    }
}

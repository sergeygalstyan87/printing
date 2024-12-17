@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/assets/css/demo8.css') }}" />
@endpush

@section('content')

    <section class="ec-page-content section-space-p refunds_section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Refunds</h2>
                        <h2 class="ec-title">Refunds</h2>
{{--                        <p class="sub-title mb-3">Welcome to the ekka multivendor marketplace</p>--}}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ec-common-wrapper">
                        <div class="col-sm-12 ec-cms-block">
                            <div class="ec-cms-block-inner">
                                <p>
                                    At yansprint.com, we strive to provide our Users with the best possible printing
                                    experience. If you are not 100% satisfied with your order for any reason, please
                                    contact our customer service department. Our representative will document your
                                    complaint and create a ticket for your reference. All policies are subject to change
                                    without prior notification.
                                </p>
                                <p>
                                    Refund Policy: In the event that a User cancels an order prior to the “In
                                    Production” status, then the User will, upon request, receive a refund proportional
                                    to the time period between the date of the User’s payment and the cancellation date
                                    (see grid below). Once the order moves to “In Production” status all refunds are at
                                    yansprint.com’s sole discretion.
                                </p>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>
                                            Time of Cancellation Relative to Payment Date
                                        </th>
                                        <th>
                                            Refund As A % of Total Order Value
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Less than 1 month</td>
                                        <td>100%</td>
                                    </tr>
                                    <tr>
                                        <td>Less than 2 month</td>
                                        <td>80%</td>
                                    </tr>
                                    <tr>
                                        <td>Less than 3 month</td>
                                        <td>60%</td>
                                    </tr>
                                    <tr>
                                        <td>Less than 4 month</td>
                                        <td>40%</td>
                                    </tr>
                                    <tr>
                                        <td>Less than 5 month</td>
                                        <td>20%</td>
                                    </tr>
                                    <tr>
                                        <td>More than 5 months</td>
                                        <td>0%</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <p>
                                    In the event an order has multiple items and some items of an order have been
                                    fulfilled, the eligible refund amount will be reduced by the value of the item
                                    fulfilled, the sales tax associated with that fulfilled item and any shipping fees
                                    associated with that fulfilled item.
                                </p>
                                <p>
                                    Return Policy: Defective products will be reprinted and sent to User at no cost to
                                    User. Determination of defect is at the sole discretion of yansprint.com. In most
                                    cases, Users will be requested to submit digital photos documenting the product
                                    defect and/or ship the defective products back to customer service. Free expedited
                                    reprint on any orders lost in transit is limited to orders less than or equal to
                                    $250. Turnaround and shipping for reprint orders will vary depending upon available
                                    production capacity and manager's discretion.
                                </p>
                                <p>
                                    Return Policy for Direct Mail Services: Direct mail services including printing,
                                    mailing services, list services and design services are not subject to the foregoing
                                    return policies. All complaints regarding the direct mail services must be
                                    registered within three days of receipt of the final printing job. Reprints on
                                    direct mail orders will be evaluated on a case-by-case basis and any reprint shall
                                    be determined by yansprint.com in its sole discretion. Postage is not refundable
                                    once the mail piece has been dropped off to the post office.
                                </p>
                                <p>
                                    All complaints must be registered within 3 days of receipt of your final printing
                                    job.
                                </p>
                                <p>
                                    In no case is yansprint.com or its affiliates liable for loss of business;
                                    incidental or consequential damages; or costs in excess of billing for services
                                    related to the specific job. YANSPRINT.COM is also not liable for returned mail
                                    pieces that are undeliverable for any reason. ALL PURCHASES OR SALES ARE SUBJECT TO
                                    THE INDEMNITIFCATION, LIMITATION OF LIABILITY, AND DISPUTE RESOLUTION AND BINDING
                                    ARBITRATION TERMS ABOVE.
                                </p>
                                <p>
                                    If you dispute any charge that is made to your credit/debit card, you agree that
                                    yansprint.com may authorize a third-party vendor to handle and seek to resolve such
                                    dispute on yansprint.com behalf, which may include yansprint.com providing vendor
                                    with the following information: your name, physical address, email address, phone
                                    number and the first 6 and last 4 digits of your credit/debit card number. You agree
                                    that yansprint.com may provide such information to the third-party vendor and that
                                    the third-party vendor may further disclose that information to your credit/debit
                                    card company, the bank issuing the credit/debit card and yansprint.com merchant
                                    processing company for the purpose of resolving the dispute. yansprint.com will
                                    endeavor to have the third-party vendor agree to maintain the confidentiality of
                                    such information.
                                </p>
                                <p>
                                    If you dispute valid charges made by yansprint.com to your credit/debit card and
                                    your dispute is subsequently found to be fraudulent, you agree to reimburse
                                    yansprint.com expenses, including banks and attorney’s fees incurred in connection
                                    with resolving the dispute.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script src="{{ asset('front/assets/js/vendor/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugins/jquery.sticky-sidebar.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
@endpush

@extends('front.layouts.main')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/assets/css/demo8.css') }}"/>
    <style>
        .terms .ec-cms-block p {
            white-space: unset;
        }

        .terms ul {
            list-style: disc;
            margin-left: 40px;
            margin-bottom: 15px;
        }

        .terms ul li {
            list-style: disc;
        }

        .terms .lower_alpha li {
            list-style: lower-alpha;
        }
    </style>
@endpush

@section('content')

    <section class="ec-page-content section-space-p terms">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Terms and Conditions</h2>
                        <h2 class="ec-title">Terms and Conditions</h2>
                        {{--                        <p class="sub-title mb-3">Welcome to the ekka multivendor marketplace</p>--}}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ec-common-wrapper">
                        <div class="col-sm-12 ec-cms-block">
                            <div class="ec-cms-block-inner">
                                <p>YANSPRINT.COM IS OWNED AND OPERATED BY YANS CREATIVE TEAM INC. BY VISITING, USING
                                    AND/OR REGISTERING WITH YANSPRINT.COM ("SITE"), YOU (REFERRED TO HEREAFTER AS "YOU",
                                    "YOUR" OR "USER") AGREE TO BE BOUND BY THE FOLLOWING TERMS AND CONDITIONS ("TERMS &
                                    CONDITIONS" or “TERMS”). PLEASE READ AND CAREFULLY REVIEW THESE TERMS & CONDITIONS,
                                    AS THEY CONSTITUTE A LEGALLY BINDING AGREEMENT BETWEEN YOU AND YANS CREATIVE TEAM
                                    INC (TOGETHER WITH ITS AFFILIATES HEREAFTER ALSO REFERRED TO BY THE BRAND NAME OF
                                    THIS SITE, “YANSPRINT.COM” AS WELL AS "WE", "US", OR "OUR") AND GOVERN ANY AND ALL
                                    USE OF THE SITE BY ANY AND ALL USERS OF THE SITE AND ANY SERVICES OFFERED
                                    THEREFROM.
                                    <b>
                                        YOU SHOULD PAY ATTENTION TO THE ARBITRATION PROVISION SET FORTH BELOW
                                        WHICH, EXCEPT AND TO THE EXTENT PROHIBITED BY LAW, REQUIRES YOU TO ARBITRATE ANY
                                        CLAIMS YOU MAY HAVE AGAINST YANS CREATIVE TEAM INC. OR ITS AFFILIATES ON AN
                                        INDIVIDUAL BASIS, RATHER THAN RESOLVING DISPUTES BY JURY TRIALS OR CLASS
                                        ACTIONS.
                                    </b>
                                </p>
                                <p>
                                    IF YOU DO NOT AGREE TO ALL OF THE TERMS & CONDITIONS, PLEASE DO NOT USE THE SITE OR
                                    ANY SERVICES OFFERED OR ACCESSED THROUGH THE SITE. IF YOU (OR THE BUSINESS ENTITY
                                    WHOM YOU REPRESENT OR ARE ACTING ON BEHALF) HAVE A SEPARATE AGREEMENT WITH,
                                    YANSPRINT.COM, THE TERMS OF THAT SEPARATE AGREEMENT SHALL GOVERN TO THE EXTENT THEY
                                    ARE INCONSISTENT WITH OR OTHERWISE CONFLICT WITH ANY OF THE TERMS & CONDITIONS.
                                </p>

                                <h3 class="ec-cms-block-title">Copyright Notice</h3>
                                <p>You acknowledge that all content included on this Site, including, without
                                    limitation, the information, data, software, photographs, graphs, typefaces,
                                    graphics, images, illustrations, maps, designs, icons, written and other material
                                    and compilations (collectively, "Content") are intellectual property and copyrighted
                                    works of yansprint.com, its licensees, and/or various third-party providers
                                    ("Providers"). Reproductions or storage of Content retrieved from this Site, in all
                                    forms, media and technologies now existing or hereafter developed, is subject to the
                                    U.S. Copyright Act of 1976, Title 17 of the United States Code. Except where
                                    expressly provided otherwise by us, nothing made available to users via the Site may
                                    be construed to confer any license or ownership right in or materials published or
                                    otherwise made available through the Site or its services, whether by estoppel,
                                    implication, or otherwise. All rights not granted to you in the Terms & Conditions
                                    are expressly reserved by us.</p>

                                <h3 class="ec-cms-block-title">User Conduct & Eligibility</h3>
                                <p>You are solely responsible for the content and context of any materials you post or
                                    submit through the Site. You warrant and agree that while using the Site, you shall
                                    not upload, post, transmit, distribute or otherwise publish through the Site any
                                    materials which: (a) are unlawful, threatening, harassing or profane; (b) restrict
                                    or inhibit any other user from using or enjoying the Site; (c) constitute or
                                    encourage conduct that would constitute a criminal offense or give rise to civil
                                    liability; or (d) contain a virus or other harmful component or false or misleading
                                    indications or origin or statements of fact.</p>
                                <p>
                                    As a condition of your use of certain services offered through the Site, you may be
                                    required to register an account with us and must provide true and accurate account
                                    information at all times (including, without limitation, ensuring that your account
                                    information remains current at all times.) You agree to promptly update your
                                    membership information (if applicable) in order to keep it current, complete and
                                    accurate.
                                </p>
                                <p>
                                    <span class="text-decoration-underline">Account Security:</span> You are solely
                                    responsible for protecting the confidentiality of
                                    your password and may not disclose your password to any other person. In the event
                                    that an unauthorized user gains access to the password-protected area of the Site as
                                    a result of your acts or omissions, you agree that you shall be liable for any such
                                    unauthorized use.
                                </p>
                                <p>
                                    <span class="text-decoration-underline">Minimum Age.</span> The Site and its
                                    services are intended solely for persons who are 18 years of age or older. Any
                                    access to or use of the Site or its service by anyone under 18 years of age is
                                    expressly prohibited. By accessing or using the Site, you represent and warrant that
                                    you are 18 years old or older.
                                    unauthorized use.
                                </p>

                                <h3 class="ec-cms-block-title">User Restrictions</h3>
                                <p>
                                    You may only use this Site to make legitimate requests to purchase the products or
                                    services offered (each, a "Request"), and shall not use this Site to make any
                                    speculative, false or fraudulent Requests. You may not use robots or other automated
                                    means to access this Site, unless specifically permitted by yansprint.com. You
                                    represent that you are of sufficient legal age to create binding legal obligations
                                    for any liability you may incur as a result of your use of this Site.
                                </p>
                                <p>
                                    It is a violation of law to place a Request in a false name or with an invalid
                                    credit card. Please be aware that even if you do not give us your real name, your
                                    Web browser transmits a unique Internet address to us that can be used by law
                                    enforcement officials to identify you. Fraudulent users may be prosecuted to the
                                    fullest extent of the law.
                                </p>
                                <p>
                                    Permission is granted to electronically copy and print in hard-copy portions of this
                                    Site for the sole purpose of using this Site as a shopping resource. Any other use
                                    of materials or Content on this Site, including reproduction for a purpose other
                                    than that noted above without yansprint.com 's prior written consent is prohibited.
                                </p>
                                <p>
                                    In addition to the foregoing and in consideration of being allowed to use the Site,
                                    you agree that the following actions shall constitute a material breach of the Terms
                                    & Conditions:
                                </p>
                                <ul>
                                    <li>
                                        <p>Collecting information about the Site or users of the Site without our
                                            written consent;</p>
                                    </li>
                                    <li>
                                        <p>Modifying, framing, rendering (or re-rendering), mirroring, truncating,
                                            injecting, filtering or changing any content or information contained in the
                                            Site, without our written consent.</p>
                                    </li>
                                    <li>
                                        <p>Using any deep-link, page-scrape, robot, crawl, index, spider, click spam,
                                            macro programs, Internet agent, or other automatic device, program,
                                            algorithm or methodology which does the same things, to use, access, copy,
                                            acquire information, generate impressions or clicks, input information,
                                            store information, search, generate searches, or monitor the Site or any
                                            portion thereof;</p>
                                    </li>
                                    <li>
                                        <p>Accessing or using the Site for competitive purposes;</p>
                                    </li>
                                    <li>
                                        <p>Disguising the origin of information transmitted to, from, or through the
                                            Site.</p>
                                    </li>
                                    <li>
                                        <p>Impersonating another person;</p>
                                    </li>
                                    <li>
                                        <p>Distributing viruses or other harmful computer code;</p>
                                    </li>
                                    <li>
                                        <p>Allowing any other person or entity to impersonate you to access or use the
                                            Site;</p>
                                    </li>
                                    <li>
                                        <p>Using the Site for any purpose in violation of local, state, national,
                                            international laws</p>
                                    </li>
                                    <li>
                                        <p>Using the Site in a way that is intended to harm, or a reasonable person
                                            would understand would likely result in harm, to the user or others</p>
                                    </li>
                                    <li>
                                        <p>Circumventing any measures implemented by us aimed at preventing violations
                                            of the Terms & Conditions.</p>
                                    </li>
                                </ul>
                                <p>
                                    We expressly reserve the right, in our sole discretion, to terminate a User's access
                                    to any or all areas of the Site due to any act that would constitute a violation of
                                    these Terms & Conditions.
                                </p>
                                <h3 class="ec-cms-block-title">Linking to the Site</h3>
                                <p>
                                    Creating or maintaining any link from another website to any page on this Site
                                    without our prior written permission is prohibited. Running or displaying this Site
                                    or any material or content displayed on this Site in frames or through similar means
                                    on another website without our prior written permission is prohibited. Any permitted
                                    links to this Site must comply will all applicable laws, rule and regulations.
                                </p>
                                <h3 class="ec-cms-block-title">Copyright</h3>
                                <p>
                                    The Digital Millennium Copyright Act of 1998 (the "DMCA") provides recourse for
                                    copyright owners who believe that material appearing on the Internet infringes their
                                    rights under U.S. Copyright law. If you believe in good faith that materials
                                    appearing on this Site infringe your copyright, you (or your agent) may send us a
                                    notice requesting that the material be removed, or access to it blocked. A
                                    conforming notice must contain the following: (a) your name, address, telephone
                                    number, and email address (if any); (b) identification of the material that is
                                    claimed to be infringing or to be the subject of infringing activity and that is to
                                    be removed or access to which is to be disabled, and information reasonably
                                    sufficient to locate the material; (c) statement that you, the complaining party,
                                    has a good faith belief that use of the material in the manner complained of is not
                                    authorized by the copyright owner, its agent, or the law; (d) a statement under
                                    penalty of perjury that the information in the notification is accurate and that you
                                    are (or are authorized to act on behalf of) the owner of an exclusive right that is
                                    allegedly infringed; and (d) your physical or electronic signature as the owner or a
                                    person authorized to act on behalf of the owner of an exclusive right that is
                                    allegedly infringed.
                                </p>
                                <p>
                                    You can find more information is the U.S. Copyright Office website, currently
                                    located at http://www.loc.gov/copyright. In accordance with the DMCA, yansprint.com
                                    has designated an agent to receive notification of alleged copyright infringement in
                                    accordance with the DMCA:
                                </p>
                                <p>
                                    Physical Address:
                                </p>
                                <p>
                                    Yansprint.com <br>
                                    14701 Arminta St. Ste A <br>
                                    Panorama City, CA 91402 <br>
                                </p>
                                <h3 class="ec-cms-block-title">Links to Third-Party Websites</h3>
                                <p>
                                    From time to time, this Site may contain links to websites that are not owned,
                                    operated or controlled by us or our affiliates. All such links are provided solely
                                    as a convenience to you. If you use these links, you will leave this Site. Neither
                                    we nor any of our affiliates are responsible for any content, materials or other
                                    information located on or accessible from any other website. Neither we nor any of
                                    our affiliates endorse, guarantee, or make any representations or warranties
                                    regarding any other website, or any content, materials or other information located
                                    or accessible from such websites, or the results that you may obtain from using such
                                    websites. If you decide to access any other website linked to or from this website,
                                    you do so entirely at your own risk.
                                </p>
                                <h3 class="ec-cms-block-title">Privacy</h3>
                                <p>
                                    You confirm that you have read, understood and agree to the yansprint.com Privacy
                                    Policy, the terms of which are incorporated herein, and agree that the terms of such
                                    policy are reasonable and satisfactory to you. You consent to the use of your
                                    personal information by yansprint.com, its affiliates, third-party providers, and/or
                                    distributors in accordance with the terms of and for the purposes set forth in the
                                    yansprint.com Privacy Policy. If you are not a resident of the United States, please
                                    note that the personal information you submit to the Site will be transferred to the
                                    United States and processed by yansprint.com in order to provide this Site and its
                                    services to you, or for such other purposes (as set forth in the Privacy Policy).
                                </p>
                                <h3 class="ec-cms-block-title">DISCLAIMER OF WARRANTIES</h3>
                                <p>
                                    THE SITE, INCLUDING ALL CONTENT, FUNCTIONS, AND INFORMATION MADE AVAILABLE ON OR
                                    ACCESSED THROUGH THE SITE, IS PROVIDED ON AN "AS IS" "AS AVAILABLE" BASIS WITHOUT
                                    REPRESENTATIONS OR WARRANTIES OF ANY KIND WHATSOEVER, EXPRESS OR IMPLIED, INCLUDING
                                    WITHOUT LIMITATION NON-INFRINGEMENT, MERCHANTABILITY, OR FITNESS FOR A PARTICULAR
                                    PURPOSE. YANSPRINT.COM. DOES NOT WARRANT THAT THE SITE OR THE FUNCTIONS, FEATURES OR
                                    CONTENT CONTAINED THEREIN WILL BE TIMELY, SECURE, UNINTERRUPTED OR ERROR FREE, OR
                                    THAT DEFECTS WILL BE CORRECTED. SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF
                                    CERTAIN WARRANTIES, SO SOME OF THE ABOVE EXCLUSIONS MAY NOT APPLY TO CERTAIN USERS.
                                </p>
                                <h3 class="ec-cms-block-title">LIMITATION OF LIABILITY</h3>
                                <p>
                                    TO THE FULLEST EXTENT PERMITTED BY LAW, IN NO EVENT SHALL YANS CREATIVE TEAM INC-
                                    INCLUDING ITS OFFICERS, DIRECTORS, EMPLOYEES, REPRESENTATIVES, SUCCESSORS, ASSIGNS
                                    OR AFFILIATES (COLLECTIVELY, THE "COVERED PARTIES") - BE LIABLE FOR ANY INJURY,
                                    DEATH, LOSS, CLAIM, DAMAGE, ACT OF GOD, ACCIDENT, DELAY, OR ANY SPECIAL, EXEMPLARY,
                                    PUNITIVE, INCIDENTAL OR CONSEQUENTIAL DAMAGES OF ANY KIND, WHETHER BASED IN
                                    CONTRACT, TORT OR OTHERWISE, WHICH ARISE OUT OF OR ARE IN ANY WAY CONNECTED WITH ANY
                                    USE OF THIS SITE OR PRODUCTS OR SERVICES SOLD THEREON OR FAILURE TO PROVIDE PRODUCTS
                                    OR SERVICES THAT YOU ORDERED FROM YANSPRINT.COM, WITH ANY DELAY OR INABILITY TO USE
                                    THIS SITE, OR FOR ANY INFORMATION, SOFTWARE, PRODUCTS OR SERVICES OBTAINED THROUGH
                                    THIS SITE, EVEN IF A PARTY HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. SOME
                                    JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF LIABILITY FOR INCIDENTAL OR
                                    CONSEQUENTIAL DAMAGES, SO SOME OF THE ABOVE EXCLUSIONS MAY NOT APPLY TO CERTAIN
                                    USERS. IN NO EVENT SHALL THE COVERED PARTIES' TOTAL LIABILITY TO YOU FOR ALL
                                    DAMAGES, LOSSES AND CAUSES OF ACTION (WHETHER IN CONTRACT OR TORT, INCLUDING BUT NOT
                                    LIMITED TO NEGLIGENCE) ARISING FROM THIS AGREEMENT OR YOUR USE OF THE SITE EXCEED
                                    THE AMOUNT PAID BY YOU TO YANSPRINT.COM FOR THE REQUEST.
                                </p>
                                <h3 class="ec-cms-block-title">Indemnification</h3>
                                <p>
                                    You agree to defend, indemnify and hold harmless the Covered Parties (as defined
                                    above) from and against any and all claims, damages, costs and expenses, including
                                    attorneys' fees, arising from or related to (A) your use of the Site, (B) your
                                    breach of the Terms & Conditions, (C) your dispute with another user, (D) the
                                    unauthorized access to any password-protected area of the Site using your password,
                                    (E) any image or content being reproduced as part of your order; (F) any alleged or
                                    actual infringement, misappropriation or violation of intellectual property rights
                                    by any image, content or other materials provided by You in connection with the
                                    Site, and (G) circumstances where user uses copy, photographs, or illustrations that
                                    are believed by others to be degrading, libelous or harmful to their reputations,
                                    images, or standing in the community or which in yansprint.com sole judgment is an
                                    infringement on a trademark, or trade name, or service mark, or copyright belonging
                                    to others, or in a suit or court action brought against for actions of the user or
                                    user's employees which may occur as a result of any mailing service including
                                    mailing list rentals. If using the Site on behalf of a Third Party (as described
                                    below), you agree to defend, indemnify and hold harmless the Covered Parties as
                                    described on behalf of yourself and any Third Party.
                                </p>
                                <h3 class="ec-cms-block-title">Third Parties</h3>
                                <p>
                                    If you use this Site to submit Requests for or on behalf of a third party ("Third
                                    Party"), you are responsible for any error in the accuracy of information provided
                                    in connection with such use as well as for any Request submitted, including related
                                    fees, charges and performance obligations. In addition, you must inform the Third
                                    Party of all Terms & Conditions applicable to all products or services acquired
                                    through this Site, including all rules and restrictions applicable thereto.
                                    yansprint.com may sublicense the rights that you grant it in this Section to a
                                    third-party subcontractor only for purposes of operating the Site, providing the
                                    product and services, processing your order, and producing and shipping your
                                    products.
                                </p>
                                <h3 class="ec-cms-block-title">User Social Media Content License</h3>
                                <p>
                                    Yansprint.com may reach out to social media users to seek their permission to
                                    feature our favorite social media content including photos, text, graphics, audio,
                                    video, location information, comments and other materials from such social media
                                    sites (“User Social Media Content”) on our Site and promotional materials. If you
                                    choose to allow us to use your User Social Media Content, you agree to the following
                                    User content license:
                                </p>
                                <p>
                                    You hereby grant to yansprint.com a worldwide, perpetual, irrevocable, royalty-free,
                                    fully-paid, non-exclusive, transferable, sublicensable right to use your User Social
                                    Media Content including photos, text, graphics, audio, video, location information,
                                    comments and other materials from social media sites in any manner to be determined
                                    in yansprint.com discretion, including but not limited to on webpages and social
                                    media pages operated by yansprint.com, e-mails and advertisements, and in any and
                                    all other marketing, promotional and advertising initiatives, and in any media now
                                    or hereafter known. yansprint.com may use, display, produce, distribute, transmit,
                                    create derivative works from, combine with other materials, alter and/or edit your
                                    User Social Media Content in any manner in our sole discretion, with no obligation
                                    to you whatsoever.
                                </p>
                                <p>
                                    You grant yansprint.com the right to use your username, real name, image, likeness,
                                    descriptions of you, location or other identifying information, including but not
                                    limited to your voice, in connection with any use of your User Social Media Content.
                                </p>
                                <p>
                                    You hereby agree and represent and warrant that (i) you are solely responsible for
                                    your User Social Media Content, (ii) you own all rights in and to your User Social
                                    Media Content and/or have obtained appropriate rights and permissions from any and
                                    all other persons and/or entities who own, manage or otherwise claim any rights with
                                    respect to such User Social Media Content, (iii) you are not a minor, (iv)
                                    yansprint.com use of your User Social Media Content as described herein will not
                                    violate the rights, including but not limited to copyright, trademark, patent, trade
                                    secret, privacy, publicity, moral, proprietary or other rights, of any third party,
                                    or any law, rule or regulation, and (v) the User Social Media Content is not
                                    libelous, defamatory, obscene, pornographic, abusive, indecent, threatening,
                                    harassing, hateful, or offensive or otherwise unlawful.
                                </p>
                                <p>
                                    You acknowledge and agree that You will make no monetary or other claim against
                                    yansprint.com for the use of the User Social Media Content. You waive the right of
                                    prior approval for the use of the User Social Media Content. You acknowledge and
                                    release yansprint.com and its assigns, licensees, and successors from all claims
                                    that may arise regarding the use of the User Social Media Content including, but not
                                    limited to, any claims of defamation, invasion of privacy, or infringement of moral
                                    rights, rights of publicity, or copyright. yansprint.com is permitted though not
                                    obligated, to include your name as a credit in connection with the use of the User
                                    Social Media Content.
                                </p>
                                <h3 class="ec-cms-block-title">User Comments, Feedback and Other Submissions</h3>
                                <p>
                                    All comments, feedback, suggestions and ideas disclosed, submitted or offered to a
                                    Covered Party in connection with your use of this Site (collectively, "Comments"),
                                    shall become and remain the exclusive property of yansprint.com. The Comments may be
                                    used by a Covered Party in any medium and for any purpose worldwide, without
                                    obtaining your specific consent and you relinquish all rights to such Comments. No
                                    Covered Party is under any obligation to maintain your Comments (and the use of your
                                    first name and first initial of your last name with any comments) in confidence, to
                                    pay to you any compensation for any Comments submitted or to respond to any of your
                                    Comments. You agree you will be solely responsible for the content of any Comments
                                    you make.
                                </p>
                                <h3 class="ec-cms-block-title">Termination</h3>
                                <p>
                                    Yansprint.com reserves the right to terminate your account and access to the Site
                                    and its services at any time. Termination by yansprint.com may include removal of
                                    access to the service, deletion of your password, deletion of all related
                                    information and files, may include the deletion of content associated with your
                                    account (or any part thereof), and other steps intended to bar your further use of
                                    the Site and its services. If you become dissatisfied with the Site, your sole and
                                    exclusive remedy is to immediately discontinue use of the Site.
                                </p>
                                <h3 class="ec-cms-block-title">Amendments to Terms & Conditions</h3>
                                <p>
                                    Yansprint.com reserves the right, at our sole discretion, to change, modify or
                                    otherwise alter the Terms & Conditions at any time. You agree that we may modify the
                                    Terms & Conditions and such modifications shall be effective immediately upon
                                    posting. You agree to review these terms and conditions periodically to be aware of
                                    modifications. Continued access or use of the Site following such posting shall be
                                    deemed conclusive evidence of your acceptance of the modified Terms & Conditions
                                    except and to the extent prohibited by applicable state or federal law.
                                </p>
                                <h3 class="ec-cms-block-title">Changes to the Site</h3>
                                <p>
                                    We reserve the right, for any reason, in our sole discretion, to terminate, suspend
                                    or change any aspect of the Site including but not limited to content, prices,
                                    features or hours of availability. We may impose limits on certain features of the
                                    Site or restrict your access to any part or all of the Site without notice or
                                    penalty. You agree that yansprint.com will not be liable to you or to any third
                                    party for any such limitation, modification, change, suspension or discontinuance of
                                    the Site.
                                </p>
                                <h3 class="ec-cms-block-title">Miscellaneous</h3>
                                <p>
                                    The captions in these Terms & Conditions are only for convenience and do not, in any
                                    way, limit or otherwise define the terms and provisions of these Terms & Conditions.
                                    None of the Covered Parties are responsible for any errors or delays in responding
                                    to a Request caused by an incorrect email address provided by you or other technical
                                    problems beyond their control. If any provision of the Terms & Conditions is held to
                                    be invalid or unenforceable by a court of competent jurisdiction, then such
                                    provision shall be enforced to the maximum extent possible so as to effect the
                                    intent of the Terms & Conditions, and the remainder of the Terms & Conditions shall
                                    continue in full force and effect. The failure by either you or yansprint.com to
                                    exercise or enforce any right or provision of the Terms & Conditions shall not
                                    constitute a waiver of such right or provision. You agree that any cause of action
                                    arising out of or related to the Site or the Terms & Conditions must commence within
                                    one (1) year after the cause of action arose; otherwise, such cause of action is
                                    permanently barred. All provisions in the Terms & Conditions regarding
                                    representations and warranties, indemnification, disclaimers, and limitation of
                                    liability shall survive the termination of the Terms & Conditions.
                                </p>
                                <h3 class="ec-cms-block-title">Entire Agreement</h3>
                                <p>
                                    These Terms & Conditions, together with the Privacy Policy and those terms and
                                    conditions incorporated herein or referred to herein, constitute the entire
                                    agreement (collectively, the "Agreement") between you and each Covered Party
                                    relating to the subject matter hereof, and supersedes any prior understandings or
                                    agreements (whether oral or written) regarding the subject matter, and may not be
                                    amended or modified except in writing or by making such amendments or modifications
                                    available on this Site.
                                </p>
                                <h3 class="ec-cms-block-title">Governing Law & Exclusive Venue for Disputes Not Subject
                                    to Arbitration</h3>
                                <p>
                                    The internal laws of the State of California shall govern the performance of these
                                    Terms & Conditions, without regard to such state's conflicts of laws principles. To
                                    the extent any claim, cause of action, or request for relief is not subject to
                                    arbitration as described below, you consent to the exclusive jurisdiction and venue
                                    of the state and federal courts located in the County of Los Angeles in the State of
                                    California, and waive any jurisdictional, venue or inconvenient forum objections to
                                    such courts.
                                </p>
                                <p>
                                    <span class="text-decoration-underline">Notice for Users in California Only.</span>
                                    This notice is for users of the Site residing in the State of California. Please be
                                    advised that the Complaint Assistance Unit of the Division of Consumer Services of
                                    the California Department of Consumer Affairs may be reached by mail at 1625 North
                                    Market Blvd., Sacramento, CA 95834 or by telephone at (800) 952-5210.
                                </p>
                                <h3 class="ec-cms-block-title">Dispute Resolution and Binding Arbitration</h3>
                                <p>
                                    Please read this section carefully. It affects your rights.
                                </p>
                                <p>
                                    ANY CLAIM, DISPUTE OR CONTROVERSY (WHETHER IN CONTRACT, TORT OR OTHERWISE, WHETHER
                                    PRE-EXISTING, PRESENT OR FUTURE, AND INCLUDING STATUTORY, CONSUMER PROTECTION,
                                    COMMON LAW, INTENTIONAL TORT, INJUNCTIVE AND EQUITABLE CLAIMS) BETWEEN YOU AND US
                                    ARISING FROM OR RELATING IN ANY WAY TO YOUR USE OF THE SITE, PURCHASE FROM
                                    YANSPRINT.COM, OR THE SALE OF PRODUCTS OR SERVICES BY YANSPRINT.COM, WILL BE
                                    RESOLVED EXCLUSIVELY AND FINALLY BY BINDING ARBITRATION RATHER THAN IN COURT. YOU
                                    AGREE TO GIVE UP ANY RIGHTS TO LITIGATE CLAIMS IN A COURT OR BEFORE A JURY, OR TO
                                    PARTICIPATE IN A CLASS ACTION OR REPRESENTATIVE ACTION WITH RESPECT TO A CLAIM.
                                    OTHER RIGHTS THAT YOU WOULD HAVE IF YOU WENT TO COURT MAY ALSO BE UNAVAILABLE OR MAY
                                    BE LIMITED IN ARBITRATION, INCLUDING DISCOVERY AND APPEAL RIGHTS. This arbitration
                                    provision shall survive termination of these Terms & Conditions and the termination
                                    of your yansprint.com account.
                                </p>
                                <p>
                                    The arbitration will be administered by the American Arbitration Association (AAA)
                                    under its Consumer Arbitration Rules, as amended by these Terms. The Consumer
                                    Arbitration Rules are available online. The Federal Arbitration Act will govern the
                                    interpretation and enforcement of this section.
                                </p>
                                <p>
                                    The arbitrator, and not any federal, state, or local court or agency, shall have
                                    exclusive authority to resolve any dispute arising under or relating to the
                                    interpretation, applicability, enforceability, or formation of these Terms,
                                    including any claim that all or any part of these Terms are void or voidable. The
                                    arbitrator will be empowered to grant whatever relief would be available in court
                                    under law or in equity. Any award of the arbitrator(s) will be final and binding on
                                    each of the parties and may be entered as a judgment in any court of competent
                                    jurisdiction.
                                </p>
                                <h3 class="ec-cms-block-title">How do I contact yansprint.com?</h3>
                                <p>
                                    Our postal address is:
                                </p>
                                <p>
                                    YansPrint.com <br>
                                    14701 Arminta St Ste A <br>
                                    Panorama City, CA 91402 <br>
                                </p>
                                <p>
                                    We can be reached via email at hello@yansprint.com or by telephone at 747.999.50.99.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">ORDER TERMS AND CONDITIONS</h2>
                        <h2 class="ec-title">ORDER TERMS AND CONDITIONS</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ec-common-wrapper">
                        <div class="col-sm-12 ec-cms-block">
                            <div class="ec-cms-block-inner">
                                <h3 class="ec-cms-block-title">Payment</h3>
                                <p>All prices and amounts shown on this Site are in U.S. Dollars (USD), unless otherwise
                                    noted. All prices set forth on the Site and stated herein are based on current costs
                                    and subject to change without notice and payment amounts and other terms may be
                                    subject to additional agreements between User and yansprint.com If a User submits an
                                    order on the Site to purchase printing products, promotional products, mailing
                                    services, design services or other services, the User agrees that all charges, taxes
                                    and shipping/handling fees will automatically be charged to the credit card or paid
                                    by User with an approved payment method.
                                </p>
                                <p>Production of all items ordered is subject to the terms outlined below in the
                                    "Printing Turnaround Time" section, and will not begin until an order is fully paid,
                                    including shipping and handling fees, if applicable except where yansprint.com has
                                    explicitly agreed to special delayed payment terms (e.g. Net 30) with the User prior
                                    to placing an order. Users who have delayed payment agreements with yansprint.com
                                    are required to provide payment in accordance with the terms of their applicable
                                    payment agreement(s).</p>
                                <p>
                                    Once the print file(s) associated with an order have been approved by the User as
                                    described below in the "Printing Turnaround Time" section, the order will be "In
                                    Production" and no changes will be allowed to the print files, job characteristics,
                                    or printing turnaround time. After an order is In Production, the entire amount of
                                    the order along with applicable taxes and shipping/handling fees shall be deemed
                                    fully paid and non-refundable, except as provided for in the Return & Refund Policy
                                    below. Additional Service Fees, List Purchase and USPS Postal Costs are
                                    non-refundable. Except as provided for in the Return & Refund Policy below, any
                                    payment received from the User shall be deemed fully paid to yansprint.com and
                                    non-refundable at a rate of twenty percent (20%) for each calendar month that has
                                    passed since the date of the User's initial submission or date of payment, whichever
                                    is earlier, even where the print job never reaches the "In Production" or shipment
                                    phase due to no fault of yansprint.com (e.g. User fails to respond to approval of
                                    proof/print job, User fails to provide information to complete the print job or
                                    shipment, User otherwise fails to cancel his or her order prior to reaching the "In
                                    Production" phase, etc.).
                                </p>

                                <h3 class="ec-cms-block-title">Return & Refund Policy</h3>
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
                                <h3 class="ec-cms-block-title">Our Sales Tax Policy</h3>
                                <p>
                                    yansprint.com charges sales tax on orders picked-up from or shipped to addresses in
                                    accordance with state and local regulations unless you are tax exempt. If you are
                                    tax exempt, you need to send us your tax exemption certificate. If, after the User
                                    has paid the invoice, it is determined that more tax is due, then the User must
                                    promptly remit the required taxes to the taxing authority or immediately reimburse
                                    the provider for any additional taxes paid.
                                </p>
                                <h3 class="ec-cms-block-title">Promotional and Referral Codes</h3>
                                <p>
                                    Yansprint.com may offer certain promotional codes, referral codes or similar
                                    promotional coupons ("Promotional Codes") that may be redeemed for discounts, or
                                    other features or benefits related to the Site, subject to any additional terms that
                                    yansprint.com wishes. You agree that Promotional Codes: (a) must be used in a lawful
                                    manner; (b) must be used for the intended audience and purpose; (c) may not be
                                    duplicated, sold or transferred in any manner, or made available to the general
                                    public (whether posted to a public forum, coupon collecting service, or otherwise),
                                    unless expressly permitted by yansprint.com; (d) may be disabled or have additional
                                    conditions applied to them by yansprint.com at any time for any reason without
                                    liability to yansprint.com; (e) may only be used pursuant to the specific terms that
                                    yansprint.com establishes for such Promotional Code;(f) are not valid for cash or
                                    other credits or points offered via the Site; and (g) may expire prior to your use.
                                </p>
                                <h3 class="ec-cms-block-title">Proofs</h3>
                                <p>
                                    If requested, an online proof will be available for your review after we have
                                    received your files for print. Actual time will vary depending on our current
                                    workload. Jobs eligible for Proof Approval Bypass will be sent to press in
                                    accordance with the program’s terms. It is the User's responsibility to log in to
                                    their account and check on their proof. We are not liable for delays in the order
                                    caused by User's non-approval of the proof. An online proof is by no means an
                                    accurate color reproduction of your final printed piece but is the final opportunity
                                    for you to check the layout, bleeds, crops and final text. Electronic proofs do not
                                    show transparency and over print issues, nor do they show color change from RGB or
                                    Pantone to CMYK. The proof must be treated as independent from the original
                                    submitted file and thoroughly reviewed prior to approval. It should be checked
                                    against the original file for possible errors in layout, copy, spacing, punctuation
                                    or image placement. User is fully responsible for all that is contained in the final
                                    approved proof. yansprint.com offers hard copy proofs which show reasonable likeness
                                    to the final printed pieces. Such proofs are recommended for color-critical art and
                                    must be requested by the User when the print order is made. Hard copy proofs are
                                    printed on a substrate different from the actual paper stock and while its main
                                    purpose is to show color, variations may occur depending on the finish selected (AQ,
                                    matte, UV) for the final print job. We do not offer hard copy proofs for art that
                                    would be printed on uncoated paper. The request for a hard copy proof may involve an
                                    additional fee and would extend the amount of time needed to complete the job. For
                                    orders where a hard copy proof has been requested, the approval must be received by
                                    yansprint.com on or before our published cut-off times. We will make every effort to
                                    match colors in production when a hard copy proof is requested. However, it is the
                                    User's responsibility to determine if they need a hard copy proof with their print
                                    order.
                                </p>
                                <h3 class="ec-cms-block-title">Proof Approval Bypass</h3>
                                <p>
                                    Once a User receives a proof, they have 3 business days to approve or reject the
                                    proof. In the event a User has taken no action, the proof will be deemed to have
                                    been approved by User and the order will proceed into production.
                                </p>
                                <h3 class="ec-cms-block-title">Cancellation</h3>
                                <p>
                                    An order may not be canceled once it is "In Production". If the order is still in
                                    the preflight or proofing stage, it may be canceled subject to the following fees,
                                    when applicable:
                                </p>
                                <ul class="lower_alpha">
                                    <li>
                                        <p>Orders placed, paid for and then canceled before 5pm PST on the same day may
                                            be refunded in full or booked as store credit to be applied to future
                                            orders;</p>
                                    </li>
                                    <li>
                                        <p>Orders below $100 will not be subject to cancellation fees.</p>
                                    </li>
                                    <li>
                                        <p>Orders from $100 to $500 will be subject to a $15.00 cancellation fee.</p>
                                    </li>
                                    <li>
                                        <p>Accessing or using the Site for competitive purposes;</p>
                                    </li>
                                    <li>
                                        <p>Orders $500 and above will be subject to a cancellation fee of 3.5% of the
                                            full order amount.</p>
                                    </li>
                                </ul>
                                <p>
                                    We reserve the right to refuse any order you place with us. We reserve the right,
                                    but are not obligated, to limit the sales of our products or Service to any
                                    geographic region or jurisdiction. We may exercise this right on a case-by-case
                                    basis. We reserve the right to limit the quantities of any products or services that
                                    we offer. All descriptions of products or services, or product or service pricing,
                                    are subject to change at any time without notice, at our sole discretion. We reserve
                                    the right to modify or discontinue any product or service at any time. Any offer for
                                    any product or service made on this site is void where prohibited.
                                </p>
                                <h3 class="ec-cms-block-title">Color Accuracy</h3>
                                <p>
                                    Yansprint.com will reproduce color from submitted print-ready files as closely as
                                    possible but cannot exactly match color and density (as viewed in a 5000K light
                                    booth). Because of inherent limitations with the printing process, as well as
                                    neighboring image ink requirements, the accuracy of color reproduction is not
                                    guaranteed. By placing an order with yansprint.com, you agree to this limitation. We
                                    will try our best to match the gradient density of each color, but we accept no
                                    responsibility for color variations between submitted files and the final printed
                                    piece. Under no circumstances will a reprint be honored for color variations that
                                    have occurred during the printing process. We are not liable for color matching or
                                    ink density on screen proofs that you approve. Screen proofs will predict design
                                    layout, text accuracy, image proportion and placement, but not color or density.
                                    Application of UV coating may affect or change the appearance of the printed colors.
                                    We are not liable for the final color appearance of a UV coated product.
                                </p>
                                <h3 class="ec-cms-block-title">No Liability for Errors</h3>
                                <p>
                                    You, the User, are responsible for ensuring that your order correctly specifies
                                    size, color, artwork, quantity, style of product, and type of product. yansprint.com
                                    is not responsible for errors made by the User during the ordering process. We have
                                    made every effort to display as accurately as possible on the website the colors,
                                    images, and artwork you upload onto a product design. We also have made every effort
                                    to ensure that the proportions and style of all customizable products appear as
                                    accurately as possible. We cannot guarantee that your computer monitor's display of
                                    any color, artwork, sizing, or feature will be accurate.
                                </p>
                                <p>
                                    Yansprint.com is not liable for errors in a final product caused by any of the
                                    following reasons:
                                </p>
                                <ul>
                                    <li>
                                        <p>Spelling, punctuation and grammatical errors</p>
                                    </li>
                                    <li>
                                        <p>Low resolution or low-quality graphics and images</p>
                                    </li>
                                    <li>
                                        <p>Damaged fonts</p>
                                    </li>
                                    <li>
                                        <p>Transparency issues</p>
                                    </li>
                                    <li>
                                        <p>Overprint issues</p>
                                    </li>
                                    <li>
                                        <p>Artwork files that are not created following our specifications</p>
                                    </li>
                                    <li>
                                        <p>Variances in color from the conversion of Pantone or RGB colors to CMYK</p>
                                    </li>
                                    <li>
                                        <p>Errors in user-selected options such as size, quantity, paper and finish</p>
                                    </li>
                                    <li>
                                        <p>Duplicate orders submitted by the User</p>
                                    </li>
                                    <li>
                                        <p>Incorrect files uploaded</p>
                                    </li>
                                    <li>
                                        <p>Incorrect file orientation</p>
                                    </li>
                                    <li>
                                        <p>Cracking on folds</p>
                                    </li>
                                    <li>
                                        <p>Cutting variances</p>
                                    </li>
                                    <li>
                                        <p>Minor discolorations due to laser cutting</p>
                                    </li>
                                    <li>
                                        <p>Application of production markings in areas that will not be visible post
                                            assembly, including but not limited to QR codes</p>
                                    </li>
                                    <li>
                                        <p>Incorrect or undeliverable shipping address</p>
                                    </li>
                                    <li>
                                        <p>Damage to products after delivery to User</p>
                                    </li>
                                </ul>
                                <p>
                                    User is responsible for reviewing their files and correcting any issues prior to
                                    placing the order. We do not warrant that the quality of any products, services,
                                    information, or other material purchased or obtained by you will meet your
                                    expectations or other requirements, or that any errors in the Service will be
                                    corrected in a timely manner or at all.
                                </p>
                                <h3 class="ec-cms-block-title">Over print and under print Policy</h3>
                                <p>
                                    Due to the gang run method that yansprint.com uses, we cannot guarantee that every
                                    order will be the exact number of items which was ordered. yansprint.com can only
                                    guarantee that it will come within plus or minus 10% of the number of items ordered.
                                    Although rare, in the event of an under run, we will either refund or give you Store
                                    Credit for the amount of pieces we were "short" if over 10% of the order quantity.
                                    In the case of flexographic and lithographic laminated orders, The User will be
                                    charged a fee for any items delivered above the original item count specified in an
                                    order. The additional charge will be the unit selling price for the item multiplied
                                    by the number of items delivered in excess of the items originally ordered plus
                                    applicable sales tax.
                                </p>
                                <h3 class="ec-cms-block-title">Artwork Files</h3>
                                <p>
                                    Our prepress department checks all submitted artwork files before printing, but you
                                    are still 100% responsible for the accuracy of your print-ready artwork files, and
                                    we encourage you to proofread all files carefully before submitting to yansprint.com
                                    is not responsible for any issues as to orientation or alignment of the pages of
                                    your submitted artwork. By submitting the artwork to yansprint.com, you certify that
                                    you have the right to use the image(s) in your artwork files. DO NOT send any
                                    "one-of-kind" transparencies, prints or artwork. Although we take every precaution
                                    to safeguard your materials, we are NOT responsible for loss or damage of images or
                                    artwork.
                                </p>
                                <p>
                                    Under these Terms & Conditions, you agree that you will NOT upload any artwork files
                                    consisting of the following material: offensive, indecent or improper material,
                                    nudity, any material that could give rise to any civil or criminal liability under
                                    applicable law; and any material that could infringe rights of privacy, publicity,
                                    copyrights or other intellectual property rights without the permission of the owner
                                    of these rights and the persons who are shown in the material if applicable. We will
                                    refuse an order based on foregoing reasons or for any other reason which in our
                                    opinion may be illegal in nature or an infringement on the rights of any third
                                    party. You accept full legal liability for the content of material processed and
                                    printed on your behalf and under your instructions. We reserve the right to refuse
                                    an order without disclosing a reason.
                                </p>
                                <p>
                                    Yansprint.com may also provide artwork design tools which offer a limited number of
                                    elements, including icons, fonts, color schemes, and design effects. We reserve the
                                    right to use and offer all such elements to other parties in the future. Other
                                    yansprint.com Users may use the same design tools to create images that may have
                                    similar or identical combinations of these elements. yansprint.com provides no
                                    warranty of any kind that artwork created using the design tool will not infringe,
                                    or be subject to a claim of infringing, on the trademark, copyright or other rights
                                    of another party. It is solely your responsibility to obtain the advice of an
                                    attorney regarding whether any image, mark, logo name or design is legally available
                                    for your use and does not infringe on another party's rights.
                                </p>
                                <p>
                                    We may, based on our sole discretion, set limits to the maximum number of days that
                                    we shall retain designs or other uploaded files, as well as the maximum storage
                                    space that we would allocate to such files. yansprint.com is not responsible for the
                                    deletion or failure to store any file whether uploaded or designed on our website.
                                    We reserve the right to delete any file stored which has been inactive for an
                                    extended period of time, or for any other reason, without prior notice.
                                </p>
                                <h3 class="ec-cms-block-title">Shipping</h3>
                                <p>
                                    Unless you choose Pick Up or Mailing Services, you need to select one of the
                                    shipping methods presented to you on the Site. All shipping may be done using FedEx,
                                    UPS or other freight carriers. yansprint.com reserves the right to use the most
                                    appropriate carrier for the required transit time and destination. When choosing a
                                    shipping method, please remember that the estimated shipping transit time is based
                                    on the number of business days in transit and does not include weekends, holidays or
                                    the day the package is picked up by the carrier. For instance, a product shipped
                                    “Two-Day” service and picked up on a Thursday would be delivered by end of day
                                    Monday.
                                </p>
                                <p>
                                    Yansprint.com responsibility is limited to preparing your printing order and turning
                                    it over to the carrier for shipping. Shipping transit times vary and yansprint.com
                                    assumes no responsibility for delays caused by shipping carriers, weather or any
                                    damages resulting from the failure to receive a job on time. Your order may arrive
                                    late due to unforeseen delays in delivery service, the breakdown of equipment,
                                    illness, etc.
                                </p>
                                <p>
                                    Yansprint.com is not liable for damages that occur during shipping. Pick up orders
                                    will be kept for 30 days from the send date of the pick-up notification email. If
                                    the order has not been picked up from yansprint.com facility within 30 days, it will
                                    be recycled. yansprint.com reserves the right to modify the shipping option selected
                                    by you and retain any related difference in charges between shipping options, where
                                    yansprint.com completes the job prior to the turnaround time selected by you and
                                    there will be no adverse material impact on the target arrival date (see Target
                                    Arrival section below).
                                </p>
                                <h3 class="ec-cms-block-title">Target Arrival</h3>
                                <p>
                                    Target arrival dates are calculated by adding the printing turnaround time to the
                                    shipping transit time. Both printing and shipping times are based on business days
                                    only and do not include weekends or holidays.
                                </p>
                                <p>
                                    For example, a product with a printing turnaround time of two business days and a
                                    shipping method of “Two- Day” service would have a target arrival date of four
                                    business days after your files have been sent to production.
                                </p>
                                <p>
                                    If you have requested a hard copy proof, factor in approximately six business days
                                    to receive and approve your proof. For next day hard copy proofs, factor in an
                                    additional two business days.
                                </p>
                                <p>
                                    Please understand that target arrival dates are estimates, not guarantees.
                                    Yansprint.com assumes no responsibility for delays caused by shipping carriers,
                                    weather, the breakdown of equipment, illness, etc.
                                </p>
                                <h3 class="ec-cms-block-title">International Orders and Shipments</h3>
                                <p>
                                    We welcome orders from our non-US Users. All transactions will be completed in US
                                    dollars, using the commercial exchange rate calculated by our merchant processor at
                                    the time the transaction is completed. No adjustments will be made to account for
                                    fluctuations in the exchange rate between an original transaction and any subsequent
                                    refund transaction.
                                </p>
                                <p>
                                    If your shipping destination is outside of the US, you may be required to pay taxes
                                    (including but not necessarily limited to sales, value-added, use and excise taxes),
                                    tariffs, import fees, duties and/or other fees, charges or assessments related to
                                    your order. We recommend consulting a Customs Broker to assist with this topic.
                                    Yansprint.com does not collect any taxes, fees, duties or other charges or
                                    assessments for non-US shipments, and you will be responsible for paying them at the
                                    time of your order's receipt.
                                </p>
                                <h3 class="ec-cms-block-title">Mailing Services</h3>
                                <p>
                                    Yansprint.com offers mailing services to users who upload their own mailing lists
                                    "Uploaded Lists" and to users who rent a mailing list from yansprint.com "Rented
                                    Lists". It is the User's responsibility to understand and comply with current
                                    mailing restrictions and all applicable federal, state and local laws, rules and
                                    regulations regarding direct mail marketing before placing the order with
                                    yansprint.com.
                                </p>
                                <p>
                                    While in our possession, Uploaded Lists remain the exclusive property of the User
                                    and shall be used only with User's instructions. User is responsible for checking
                                    the accuracy of Uploaded Lists before submitting to yansprint.com and to make sure
                                    that there is no confidential information or notes not meant for the recipient.
                                    Uploaded Lists will not be sold or offered for use to any other party, and
                                    yansprint.com will not utilize the list for any other purpose.
                                </p>
                                <p>
                                    Yansprint.com contracts the services of third-party vendors for the procurement of
                                    Rented Lists. If you use a Rented List on yansprint.com you acknowledge that you
                                    have no proprietary rights to the data in rented lists, and that it is your
                                    responsibility to use it as per the vendor's terms by which it was rented. Rented
                                    Lists are only available for your marketing purposes. You do not have the right to
                                    transfer or sell Rented Lists to other parties.
                                </p>
                                <h3 class="ec-cms-block-title">Miscellaneous</h3>
                                <p>
                                    All complaints must be registered within 3 days of receipt of your final printing
                                    job. If we determine that your job contains manufacturing errors and/or defects, we
                                    will rerun your job at no charge.
                                </p>
                                <p>
                                    All materials we create in producing your printed product are the property of
                                    yansprint.com. Although these materials will NOT be sold to any other party, we
                                    reserve the right to distribute free samples of your printed product. Please note
                                    that your printed product or images used for your printed product will not be used
                                    in any national advertising without your prior written consent.
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

<div style="padding:0;margin:0 auto;width:100%!important;font-family:Montserrat">
    <table role="presentation" align="center" border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#EDF0F3" style="background-color:#edf0f3;table-layout:fixed">
        <tbody>
            <tr>
                <td align="center">
                    <center style="width:100%">
                        <table role="presentation" border="0" class="m_-1730743365790155293phoenix-email-container" cellspacing="0" cellpadding="0" width="512" bgcolor="#FFFFFF" style="background-color:#ffffff;margin:0 auto;max-width:512px;width:inherit">
                            <tbody>
                                <tr>
                                    <td bgcolor="#F6F8FA" style="background-color:#f6f8fa;padding:5px 16px 13px;border-bottom:1px solid #ececec">
                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%!important;min-width:100%!important">
                                            <tbody>
                                                <tr>
													<td align="left" valign="middle"><a href="{{$url}}" style="color:#0073b1;display:inline-block;text-decoration:none" target="_blank"> <img alt="" border="0" src="{{$logo_url}}" height="42" style="outline:none;color:#ffffff;text-decoration:none" title=""></a></td>
													<td valign="middle" width="100%" align="right"><a href="{{ URL::to('/') }}/user/{{$receiver->id}}/view" style="margin:0;color:#0073b1;display:inline-block;text-decoration:none" target="_blank">
                                                            <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="left" valign="middle" style="padding:0 0 0 10px;padding-top:7px">
                                                                            <p style="margin:0;font-weight:400"> <span style="word-wrap:break-word;color:#4c4c4c;word-break:break-word;font-weight:400;font-size:14px;line-height:1.429">{{$receiver->full_name}}</span></p>
                                                                        </td>
                                                                        <td valign="middle" width="40" style="padding-top:7px;padding-left:10px"> <img alt="{{$receiver->full_name}}" title="" border="0" height="36" width="36" src="{{$receiver_image_src}}" style="border-radius:50%;outline:none;color:#ffffff;text-decoration:none" ></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
														</a></td>
														<td width="1">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
								</tr>
								<tr>
                                    <td>
                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="padding:24px 24px 36px 24px">
                                                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td align="left" id="m_-1730743365790155293qatest-hero-headline" colspan="2" style="padding-bottom:12px">
                                                                                        <p style="margin:0;word-wrap:break-word;color:#4c4c4c;word-break:break-word;font-weight:400;font-size:16px;line-height:1.5">Hi {{$receiver->full_name}}, I sent you a message in Growyspace.</p>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td valign="top" width="70" style="width:70px">
                                                                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%">
                                                                                            <tbody>
                                                                                                <tr>
																								<td id="m_-1730743365790155293qatest-hero-profilepic" style="padding:10px 24px 0 0"><a href="{{ URL::to('/') }}/user/{{$sender->id}}/view" style="color:#0073b1;display:inline-block;text-decoration:none" target="_blank" ><img src="{{$sender_image_src}}" alt="" title="" height="70" width="70" style="border-radius:50%;outline:none;color:#ffffff;text-decoration:none" ></a></td>
																								</tr>
                                                                                            </tbody>
                                                                                        </table>
																					</td>
																					<td style="padding-top:5px">
                                                                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td valign="top" id="m_-1730743365790155293qatest-hero-profileinfo"><a href="{{ URL::to('/') }}/user/{{$sender->id}}/view"  style="color:#0073b1;display:inline-block;text-decoration:none" target="_blank" > <span style="word-wrap:break-word;color:#262626;word-break:break-word;font-weight:700;font-size:16px;line-height:1.5">{{$sender->full_name}}</span></a>
                                                                                                        <p style="margin:0;word-wrap:break-word;color:#737373;word-break:break-word;font-weight:400;font-size:14px;line-height:1.429">{{$sender->profession}}</p>
                                                                                                        <p style="margin:0;color:#737373;font-weight:400;font-size:14px;line-height:1.429">{{$sender->city}}, {{config('yourconfig.countries')[$sender->country_code]}}</p>
                                                                                                    </td>
																								</tr>
																								<tr>
                                                                                                    <td dir="rtl" align="left" style="direction:rtl!important;text-align:left!important"> <span id="m_-1730743365790155293qatest-cta-accept" style="display:inline-block;margin-top:14px">
                                                                                                            <table border="0" cellpadding="0" cellspacing="0" style="display:inline-block">
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align="center" valign="middle"><a href="{{ URL::to('/') }}/messages/{{$sender->id}}" style="word-wrap:normal;color:#0073b1;word-break:normal;white-space:nowrap;display:block;text-decoration:none" target="_blank" >
                                                                                                                                <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="auto">
                                                                                                                                    <tbody>
                                                                                                                                        <tr>
                                                                                                                                            <td bgcolor="#332960" style="padding:6px 16px;color:#ffffff;font-weight:500;font-size:16px;border-color:#332960;background-color:#332960;border-radius:15px;border-width:1px;border-style:solid"><a href="{{ URL::to('/') }}/messages/{{$sender->id}}" style="color:#ffffff;display:inline-block;text-decoration:none" target="_blank" >View message</a></td>
                                                                                                                                        </tr>
                                                                                                                                    </tbody>
                                                                                                                                </table>
                                                                                                                            </a></td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </span> <span id="m_-1730743365790155293qatest-cta-profile" style="display:inline-block;margin-top:14px;margin-right:12px">
                                                                                                            <table border="0" cellpadding="0" cellspacing="0" style="display:inline-block">
                                                                                                                <tbody>
                                                                                                                    <tr>
                                                                                                                        <td align="center" valign="middle"><a href="{{ URL::to('/') }}/user/{{$sender->id}}/view" style="word-wrap:normal;color:#0073b1;word-break:normal;white-space:nowrap;display:block;text-decoration:none" target="_blank" >
                                                                                                                                <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="auto">
                                                                                                                                    <tbody>
                                                                                                                                        <tr>
                                                                                                                                            <td style="border-radius:15px;padding:6px 16px;color:#4c4c4c;font-weight:500;font-size:16px;border-color:#737373;border-width:1px;border-style:solid"><a href="{{ URL::to('/') }}/user/{{$sender->id}}/view" style="color:#4c4c4c;display:inline-block;text-decoration:none" target="_blank" >View profile</a></td>
                                                                                                                                        </tr>
                                                                                                                                    </tbody>
                                                                                                                                </table>
                                                                                                                            </a></td>
                                                                                                                    </tr>
                                                                                                                </tbody>
                                                                                                            </table>
                                                                                                        </span> </td>
																								</tr>
																								</tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div>
                                                            <div> </div>
                                                            <div> </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
								</tr>
								<tr>
                                    <td>
                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%" bgcolor="#EDF0F3" align="center" style="background-color:#edf0f3;padding:0 24px;color:#6a6c6d;text-align:center">
                                            <tbody>
                                                <tr>
                                                    <td align="center" style="padding:16px 0 0 0;text-align:center">
                                                        <table role="presentation" align="center" border="0" cellspacing="0" cellpadding="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="middle" align="center" style="padding:0 0 16px 0;vertical-align:middle;text-align:center"><a href="{{ URL::to('/') }}/user/{{$receiver->id}}/unsubscribe" style="color:#6a6c6d;text-decoration:underline;display:inline-block" target="_blank" > <span style="color:#6a6c6d;font-weight:400;text-decoration:underline;font-size:12px;line-height:1.333">Unsubscribe</span></a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="center" style="padding:0 0 12px 0;text-align:center">
                                                                        <p style="margin:0;color:#6a6c6d;font-weight:400;font-size:12px;line-height:1.333">You are receiving reminder email.</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center" style="padding:0 0 12px 0;text-align:center">
                                                                        <p style="margin:0;color:#6a6c6d;font-weight:400;font-size:12px;line-height:1.333">© growyspace.com 2021 </p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </td>
            </tr>
        </tbody>
    </table> 
    <div class="yj6qo"></div>
    <div class="adL"> </div>
</div>
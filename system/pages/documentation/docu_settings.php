<div class="page_full">
	<div class="page_element item_page_title">
		<p class="bold"><i class="fa fa-cogs"></i> Settings definition</p>
	</div>
</div>
<div class="page_element">
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Main options
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Index path
			</div>
			<div class="docu_option_description sub_text">
				Index path is the most important setting of the chat it must be 
				the absolute path to your current chat. Index path must <span class="theme_color">not</span>
				end with a /.
			</div>
			<div class="docu_option_title">
				Site title
			</div>
			<div class="docu_option_description sub_text">
				Name of your site that will be displayed on the browser tab.
			</div>
			<div class="docu_option_title">
				Site description
			</div>
			<div class="docu_option_description sub_text">
				Here you can add your site description this will add description of
				your site in the head tag of each pages.
			</div>
			<div class="docu_option_title">
				Site keyword
			</div>
			<div class="docu_option_description sub_text">
				Keyword of your site must be added and separated by 
				a coma ex : chat, room, chatroom, mobile...
			</div>
			<div class="docu_option_title">
				Site timezone
			</div>
			<div class="docu_option_description sub_text">
				Define the current timezone selection for displaying current time in chat
			</div>
			<div class="docu_option_title">
				Default language
			</div>
			<div class="docu_option_description sub_text">
				Define the default system language.
			</div>
			<div class="docu_option_title">
				Default theme
			</div>
			<div class="docu_option_description sub_text">
				Define the default system theme.
			</div>
			<div class="docu_option_title">
				System name
			</div>
			<div class="docu_option_description sub_text">
				Define the default system name that will be displayed when message are sent by the system.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Registration options
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Bridge login
			</div>
			<div class="docu_option_description sub_text">
				That option is only turned on when you want to use a bridge to login using other
				cms like wordpress, drupal etc... Note that you need to install the bridge first
				to be able to activate that function. Check on Bcaccess for available bridge.
			</div>
			<div class="docu_option_title">
				Allow new registration
			</div>
			<div class="docu_option_description sub_text">
				Turn on and off site registration if turned off a message will
				be displayed to visitor that registration are closed.
			</div>
			<div class="docu_option_title">
				Ask for verification
			</div>
			<div class="docu_option_description sub_text">
				If turned on this option will ask to all new members
				to verify their account before they will be able to enter the system.
			</div>
			<div class="docu_option_title">
				Mute new account
			</div>
			<div class="docu_option_description sub_text">
				This option will mute all new registered member for the selected time this is a good
				tool that can give you time to verify some details about users before they be able to chat and 
				prevent spammer to enter your chat and spam right away.
			</div>
			<div class="docu_option_title">
				Max registration per day
			</div>
			<div class="docu_option_description sub_text">
				Define the maximum registration that the same ip can do in the system
				per 24 hours period.
			</div>
			<div class="docu_option_title">
				Allow duplicate email registration
			</div>
			<div class="docu_option_description sub_text">
				Allow or not registration with same email. If turned off only 1 account 
				can register per email.
			</div>
			<div class="docu_option_title">
				Max username length
			</div>
			<div class="docu_option_description sub_text">
				Define the maximum characters allowed to username when a new member register
				to the system.
			</div>
			<div class="docu_option_title">
				Minimum age to register
			</div>
			<div class="docu_option_description sub_text">
				Define the minimum age required to register to the system.
			</div>
			<div class="docu_option_title">
				Allow guest
			</div>
			<div class="docu_option_description sub_text">
				Allow member to use the guest login to enter chat. Note that
				guest can bring lot of problem due to vpn or other tool used
				for changing ip. When this option is turned off the system will
				automaticly delete all guest members from the database.
			</div>
			<div class="docu_option_title">
				Allow guest name
			</div>
			<div class="docu_option_description sub_text">
				If this option is turned on it will allow guest to choose their name. Note that
				the guest prefix will not aply with guest name activated. When a guest quit his 
				name will be available again 2 min after last action.
			</div>
			<div class="docu_option_title">
				Guest prefix
			</div>
			<div class="docu_option_description sub_text">
				When not using the guest name option this will name your guest with a prefix
				example: @guest_01, @guest_02. You can change the prefix to your desired prefix
				but note that you are required to provide a prefix.
			</div>
			<div class="docu_option_title">
				Activate facebook login
			</div>
			<div class="docu_option_description sub_text">
				If turned on the facebook login button will apear in the login 
				form and registration form. ( require to make a facebook app )
			</div>
			<div class="docu_option_title">
				Facebook app id
			</div>
			<div class="docu_option_description sub_text">
				Field where you insert your Facebook app id that you have created.
			</div>
			<div class="docu_option_title">
				Facebook app secret
			</div>
			<div class="docu_option_description sub_text">
				Field where you insert your Facebook app secret that you have created.
			</div>
			<div class="docu_option_title">
				Google recaptcha
			</div>
			<div class="docu_option_description sub_text">
				To activate google recaptcha you need to create your recaptcha api key <a href="https://www.google.com/recaptcha/intro/v3beta.html" class="theme_color">here</a> you need to set your api key to 
				recaptcha version 2.0 and not 3.0 this is important.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Email settings
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Mail system type
			</div>
			<div class="docu_option_description sub_text">
				You can select mail or smtp the mail function will use the basic mail() php function
				and the smtp will use smtp mail connection. Important to note that some
				vps and shared host may block the smtp function on their server to prevent spamming
				and keep their reputation. If the smtp is not working for you please contact your
				host provider and make sure they unlock the smtp protocol for you. Note that 
				we do not modify or support server side settings.
			</div>
			<div class="docu_option_title">
				Site email
			</div>
			<div class="docu_option_description sub_text">
				Email adress that will show in email as sender.
				Note that site email can be overwrited by the smtp server email.
			</div>
			<div class="docu_option_title">
				Sender name
			</div>
			<div class="docu_option_description sub_text">
				Name from who the email is coming from.
			</div>
			<div class="docu_option_title">
				Smtp host
			</div>
			<div class="docu_option_description sub_text">
				Smtp host server adress.
			</div>
			<div class="docu_option_title">
				Smtp username
			</div>
			<div class="docu_option_description sub_text">
				Smtp username to connect to smtp server.
			</div>
			<div class="docu_option_title">
				smtp password
			</div>
			<div class="docu_option_description sub_text">
				Password of smtp to connect to smtp server
			</div>
			<div class="docu_option_title">
				Smtp port
			</div>
			<div class="docu_option_description sub_text">
				Port to connect to your smtp server.
			</div>
			<div class="docu_option_title">
				Smtp encryption
			</div>
			<div class="docu_option_description sub_text">
				Smtp encryption type can be ssl or tls that refer to your smtp server.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Chat options
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Default count on room creation
			</div>
			<div class="docu_option_description sub_text">
				Define the limit user that a room can contain when creating a room if set to 0 
				the room will be unlimited.
			</div>
			<div class="docu_option_title">
				Display system logs
			</div>
			<div class="docu_option_description sub_text">
				If turned on this option will show message when user enter or leave room.
			</div>
			<div class="docu_option_title">
				Show userlist icons
			</div>
			<div class="docu_option_description sub_text">
				If turned on this option display ranking and gender icons in the userlist.
			</div>
			<div class="docu_option_title">
				Main chat max character
			</div>
			<div class="docu_option_description sub_text">
				Maximum allowed character per post in main chat box.
			</div>
			<div class="docu_option_title">
				Private chat max character
			</div>
			<div class="docu_option_description sub_text">
				Maximum allowed character per post in private box.
			</div>
			<div class="docu_option_title">
				Innactivity balancer
			</div>
			<div class="docu_option_description sub_text">
				When activated this function will slower chat refreshing rate for innactive members and
				help to balance the server load when many users are chatting at same time. This function
				will improve chat response time and is strongly recommended the effect of this function
				is immediate and will affect all online users without the need of refreshing.
			</div>
			<div class="docu_option_title">
				Display offline users
			</div>
			<div class="docu_option_description sub_text">
				If turned on this feature will display a offline and online list of users in room.
				if no offline users the list will not apear.
			</div>
			<div class="docu_option_title">
				Chat refresh delay
			</div>
			<div class="docu_option_description sub_text">
				Lower this value is faster the chat refresh but higher is the server usage
				. 3000 - 3500 are recommended settings. Note that lowering that value under
				3000 will not make chat faster if your server is not capable of such speed and will
				create the oposite effect as expected.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Upload & database
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Max avatar size allowed
			</div>
			<div class="docu_option_description sub_text">
				Define maximum size of file allowed when uploading avatar. 
				This value must not exceed upload value from dashboard system info.
			</div>
			<div class="docu_option_title">
				Max file size allowed
			</div>
			<div class="docu_option_description sub_text">
				Define maximum file size that a user can upload. 
				this value must not exceed upload value from dashboard system info.
			</div>
			<div class="docu_option_title">
				Chat logs delete
			</div>
			<div class="docu_option_description sub_text">
				Define the time before a main chat post get deleted from the database.
				It is strongly recommended to keep this value to 7 days or lower to increase
				chat performance.
			</div>
			<div class="docu_option_title">
				Private logs delete
			</div>
			<div class="docu_option_description sub_text">
				Define the time before a private chat post get deleted from the database. It is strongly
				recommended to keep this value to 7 days or lower to increase chat performance.
			</div>
			<div class="docu_option_title">
				Wall logs delete
			</div>
			<div class="docu_option_description sub_text">
				Define the time before a wall post post get deleted from the database. It is strongly
				recommended to keep this value to 180 days or lower to increase chat performance.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Limits options
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Allow upload
			</div>
			<div class="docu_option_description sub_text">
				Define required rank to be able to access upload feature.
			</div>
			<div class="docu_option_title">
				Allow avatar
			</div>
			<div class="docu_option_description sub_text">
				Define rank required for a member to be able to upload an avatar in chat.
			</div>
			<div class="docu_option_title">
				Allow username change
			</div>
			<div class="docu_option_description sub_text">
				Define rank required for a member to be able to change his username in system.
			</div>
			<div class="docu_option_title">
				Allow mood
			</div>
			<div class="docu_option_description sub_text">
				Define rank required for a member to be able to set a mood under their name in profile and userlist.
			</div>
			<div class="docu_option_title">
				Allow account verification
			</div>
			<div class="docu_option_description sub_text">
				Define the rank required to auto verify their account. Set this option to owner if you do not wish to
				use the manual verification system inside the profile.
			</div>
			<div class="docu_option_title">
				Allow special emoticon
			</div>
			<div class="docu_option_description sub_text">
				Define required rank for a member to be able to access and use special emoticon set.
			</div>
			<div class="docu_option_title">
				Allow username color
			</div>
			<div class="docu_option_description sub_text">
				Define rank required to choose username color. Set this option to owner if you do not wish other to choose their own color.
			</div>
			<div class="docu_option_title">
				Allow text color
			</div>
			<div class="docu_option_description sub_text">
				Define required rank for a member to be able to use text color in chat.
			</div>
			<div class="docu_option_title">
				Allow direct display
			</div>
			<div class="docu_option_description sub_text">
				Define required rank for a member to be able to post image and embed youtube directly to chat.
				otherwise their link will show only as regular link.
			</div>
			<div class="docu_option_title">
				Allow room creation
			</div>
			<div class="docu_option_description sub_text">
				Define required rank to be able to create room in the system.
			</div>
			<div class="docu_option_title">
				Allow users themes
			</div>
			<div class="docu_option_description sub_text">
				Define required rank to be able to select own theme. this setting only affect room display.
			</div>
			<div class="docu_option_title">
				Allow history in chat
			</div>
			<div class="docu_option_description sub_text">
				Define required rank for a member to be able to scroll the chat to top and view history.
			</div>
			<div class="docu_option_title">
				Allow player list
			</div>
			<div class="docu_option_description sub_text">
				Define required rank to be able to choose stream station from player. If not meet requirement member
				will be attributed the default room player stream.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Badword filter
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Action to take on badword
			</div>
			<div class="docu_option_description sub_text">
				You can choose from no action, temporary mute or sytem mute. The temporary mute will mute the member for 
				the choosed time from the " bad word mute duration " setting. System mute will mute user till a staff remove the mute.
			</div>
			<div class="docu_option_title">
				Bad word mute duration
			</div>
			<div class="docu_option_description sub_text">
				Define the duration of mute on a badword. The system will automaticly unmute the member after that
				delay. This option only take effect when temporary mute is selected from " Action to take on badword " is
				selected.
			</div>
			<div class="docu_option_title">
				Add word to filter
			</div>
			<div class="docu_option_description sub_text">
				Add a badword to the wordfilter. it will filter both private and main chat.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Spam filter
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Action to take on spam
			</div>
			<div class="docu_option_description sub_text">
				You can choose from no action, mute or ban. Action taken by system on spam filter need to be removed by a staff member.
			</div>
			<div class="docu_option_title">
				Add text to spam filter
			</div>
			<div class="docu_option_description sub_text">
				Its important to do not mix spam filter and word filter. The spam filter is used for more complex word such as url or spam. Example
				if you want to block a url in the chat <span class="theme_color">www.google.com</span> you can add in spam filter <span class="theme_color">google.com</span> in the spam filter. Spam filter will 
				see some variant of the filter even if the user put space or use capital or lowercase letters example if a user type
				<span class="theme_color">w w w . G o O g L e . C o M</span> the spam filter will still detect it and aply the action.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Username filter
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Add word to name filter
			</div>
			<div class="docu_option_description sub_text">
				The name filter allow you to prevent users to register or change their name with certain word in. Example if you want to prevent members to use the word <span class="theme_color">shit</span>
				in their usename then add it to the filter. The filter is case unsensitive so you do not need to add <span class="theme_color">SHIT</span> and <span class="theme_color">shit</span> ... both 
				are covered by the filter no need to repeat them.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Email filter
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Add provider to email filter
			</div>
			<div class="docu_option_description sub_text">
				The email filter is a very powerfull tool that allow you to add in filter a list of all email provider that you accept for registration. Example if you only add <span class="theme_color">gmail</span> to 
				the filter then no email other than gmail email will be accepted for new registration. When you add provider to filter do not repeat or add anything else than the name of the provider. Example if you 
				want to add <span class="theme_color">hotmail</span> then in the filter simply add <span class="theme_color">hotmail</span>... This will cover all possible email from hotmail such as 
				<span class="theme_color">hotmail.com, hotmail.fr, hotmail.uk...</span>. Never add the @ before the provider added. You can reset email filter please read console section to know more about how to do.
			</div>
		</div>
	</div>
	<div class="docu_box">
		<div class="docu_head border_bottom sub_list">
			Player settings
		</div>
		<div class="docu_content">
			<div class="docu_option_title">
				Default stream player
			</div>
			<div class="docu_option_description sub_text">
				Define the default player stream station when creating a room. If set to no default this will
				hide the player.
			</div>
			<div class="docu_option_title">
				Stream alias
			</div>
			<div class="docu_option_description sub_text">
				Name of stream that will be visible in the player.
			</div>
			<div class="docu_option_title">
				Stream url
			</div>
			<div class="docu_option_description sub_text">
				Url of the stream source. Note that this must be a sound source and not a website that contain a source.
			</div>
		</div>
	</div>
</div>
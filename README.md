# Search in HackPad with Alfred

Huh? What!?

[HackPad](http://hackpad.com) is a web application allowing for collaborative document editing and it's awesome.

[Alfred](http://www.alfredapp.com/) is a Mac OS X productivity application that makes all kinds of things just a keystroke away and it's also awesome!

![Screenshot](https://api.monosnap.com/image/download?id=F1lVnf0YpiFAqK2wUCSnd02vo)

## Installation

You can install the Alfred workflow by downloading the [HackPad.alfredworkflow](https://github.com/eojthebrave/hackpad-alfred/raw/master/HackPad.alfredworkflow) file and opening it with Alfred.

## Usage

Invoke Alfred and type `hp` followed by whatever text you want to search for in HackPad. Alfred will start to list the relevant pads, select one and hit <key>enter</key> and it'll open that pad in your browser.

## Configuration

This workflow needs to know your HackPad API ID and Secret Key in order to make API queries on your behalf. This information can be found by accessing your account settings on the HackPad site.

Trigger Alfred and enter the text `hpsettings` to trigger the configuration commands. Then type one of `id`, `key` or `url` followed by a space and the value you would like to set for that option.

*Note:* If you use a custom hackpad URL like lullabot.hackpad.com, you will also need to enter the `url` into the settings in order for this workflow to work.

The complete command might look something like `hpsettings id MYAPIID`, then hit enter. If it works, you should see a message displayed on the screen.

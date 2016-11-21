PlateWarp is an extension for the Plugin SimpleWarp
 
**PlateWarp is not compatible with versions of [SimpleWarp](https://github.com/Falkirks/SimpleWarp) below 3.2.0.**

## Commands
| Command | Usage | Description | 
| ------- | ----- | ----------- |
| `/addwarpplate` | `/addwarpplate <name> [<x> <y> <z> [level]]` |  |
| `/delwarpplate` | `/delwarpplate <name>` | Deletes the WarpPlate for the specified Warp. |
| `/listwarps` | `/listwarps` | . |

## Permissions
```yaml
permissions:
 platewarp:
 default: op
 children:
  platewarp.use:
   default: true
   description: "Allows the use of all PlateWarps"
  platewarp.command:
  default: op
  children:
   platewarp.command.add:
    default: op
    decription: "Allows to use the /addwarpplate command"
   platewarp.command.remove:
    default: op
    decription: "Allows to use the /delwarpplate command"
   platewarp.command.list:
    default: op
    decription: "Allows to use the /listwarps command"
```

## API
What good is a plugin without an API? PlateWarp has an API.

### Getting access
Make sure to add the following to your `plugin.yml`

```yaml
depend: ["PlateWarp"]
```
**Note:** If you use `softdepend` you will need to check if PlateWarp is installed.

Now you can a copy of the API in your `onEnable` method

```php
$api = PlateWarpAPI::getInstance($this); // This only works if you have a use-d the namespace for the API class
/**
 * @deprecated If you use this you should use depend instead of softdepend, if you do want to use softdepend you should just use the method below.
 */
```

If you want to get the instance without a static method:

```php
//depend:
$api = $server->getPluginManager()->getPlugin("PlateWarp")->getApi(); // $server is an instance of \pocketmine\Server
//softdepend
$plugin = $server->getPluginManager()->getPlugin("PlateWarp"); //$server is an instance of \pocketmine\Server
$api = $plugin === null ? null : $plugin->getApi(); 
//remember to check if($api !== null) before doing any calls.
```

<?php

namespace App\Spotlight;

use Illuminate\Http\Request;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;
class ManageSessions extends SpotlightCommand
{
    /**
     * This is the name of the command that will be shown in the Spotlight component.
     */
    protected string $name = 'Manage Sessions';

    /**
     * This is the description of your command which will be shown besides the command name.
     */
    protected string $description = 'Redirect to user manage sessions page';

    /**
     * You can define any number of additional search terms (also known as synonyms)
     * to be used when searching for this command.
     */
    protected array $synonyms = ['manage','sessions', 'create'];

    /**
     * When all dependencies have been resolved the execute method is called.
     * You can type-hint all resolved dependency you defined earlier.
     */
    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirect(route('tutor.bookings.manage-sessions'));
    }
    /**
     * You can provide any custom logic you want to determine whether the
     * command will be shown in the Spotlight component. If you don't have any
     * logic you can remove this method. You can type-hint any dependencies you
     * need and they will be resolved from the container.
     */
    public function shouldBeShown(Request $request): bool
    {
        return $request->user()->role == 'tutor';
    }
}

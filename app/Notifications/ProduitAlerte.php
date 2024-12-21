<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProduitAlerte extends Notification implements ShouldQueue
{
    use Queueable;

    protected $alerte;

    /**
     * Create a new notification instance.
     */
    public function __construct($alerte)
    {
        $this->alerte = $alerte;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Alerte Stock Faible : ' . $this->alerte['produit_id'])
            ->line('Le produit avec ID ' . $this->alerte['produit_id'] . ' a un stock faible.')
            ->line('Quantité en stock : ' . $this->alerte['quantite_stock'])
            ->line('Seuil de réapprovisionnement : ' . $this->alerte['seuil_reapprovisionnement'])
            ->action('Voir Produit', url('/produits/' . $this->alerte['produit_id']))
            ->line('Veuillez réapprovisionner le stock dès que possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'alerte' => [
                'produit_id' => $this->alerte['produit_id'],
                'produit_nom' => $this->alerte['produit_nom'], // Ajoutez le nom du produit
                'quantite_stock' => $this->alerte['quantite_stock'],
                'seuil_reapprovisionnement' => $this->alerte['seuil_reapprovisionnement'],
            ],
        ];
        
    }
}

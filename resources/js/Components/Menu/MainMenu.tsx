import MainMenuItem from '@/Components/Menu/MainMenuItem';
import { CircleGauge, Printer, Users, Bolt, NotebookPen, Receipt } from 'lucide-react';

interface MainMenuProps {
  className?: string;
}

export default function MainMenu({ className }: MainMenuProps) {
  return (
    <div className={className}>
      <MainMenuItem
        text="Dashboard"
        link="dashboard"
        icon={<CircleGauge size={20} />}
      />
      <MainMenuItem
        text="Contacts"
        link="contacts.index"
        icon={<Users size={20} />}
      />
      <MainMenuItem
        text="Customers"
        link="customers.index"
        icon={<Printer size={20} />}
      />
      <MainMenuItem
        text="Invoices"
        link="invoices.index"
        icon={<Receipt size={20} />}
      />
      <MainMenuItem
        text="Parts"
        link="parts.index"
        icon={<Bolt size={20} />}
      />
      <MainMenuItem
        text="Tasks"
        link="tasks.index"
        icon={<NotebookPen size={20} />}
      />
    </div>
  );
}

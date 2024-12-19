import { Link, usePage } from '@inertiajs/react';
import { PaginatedData } from '@/types';
import MainLayout from '@/Layouts/MainLayout';
import Table from '@/Components/Table/Table';
import { Trash2 } from 'lucide-react';
import Pagination from '@/Components/Pagination/Pagination';


const Index = () => {

  const invoices = usePage<{
    invoices: PaginatedData<Invoice>;
  }>().props;

  const {
    data,
    links
  } = invoices.invoices;

  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">Invoices</h1>
      <div className="flex items-center justify-between mb-6">
        <Link
          className="btn-indigo focus:outline-none"
          href={route('invoices.create')}
        >
          <span>Create</span>
          <span className="hidden md:inline"> Invoice</span>
        </Link>
      </div>
      <Table
        columns={[
          {
            label: 'Number',
            name: 'number',
            renderCell: row => (
              <>
                {row.number}
                {row.deleted_at && (
                  <Trash2 size={16} className="ml-2 text-gray-400" />
                )}
              </>
            )
          },
          { label: 'Status', name: 'status' },
          { label: 'Task Id', name: 'task_id' },
          { label: 'Total', name: 'total' },
        ]}
        rows={data}
        getRowDetailsUrl={row => route('invoices.edit', row.id)}
      />
      <Pagination links={links} />
    </div>
  );
};

/**
 * Persistent Layout (Inertia.js)
 *
 * [Learn more](https://inertiajs.com/pages#persistent-layouts)
 */
Index.layout = (page: React.ReactNode) => (
  <MainLayout title="Invoices" children={page} />
);

export default Index;


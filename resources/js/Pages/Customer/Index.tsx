import { Link, usePage } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import Pagination from '@/Components/Pagination/Pagination';
import { Customer, PaginatedData } from '@/types';
import Table from '@/Components/Table/Table';
import { Trash2 } from 'lucide-react';

const Index = () => {

  const { customers } = usePage<{
    customers: PaginatedData<Customer>;
  }>().props;

  const {
    data,
    links
  } = customers;

  return (
    <div>
      <div>
        <h1 className="mb-8 text-3xl font-bold">Customers</h1>
        <div className="flex items-center justify-between mb-6">
          <Link
            className="btn-indigo focus:outline-none"
            href={route('customers.create')}
          >
            <span>Create</span>
            <span className="hidden md:inline"> Customer</span>
          </Link>
        </div>
        <Table
          columns={[
            {
              label: 'Name',
              name: 'name',
              renderCell: row => (
                <>
                  {row.name}
                  {row.deleted_at && (
                    <Trash2 size={16} className="ml-2 text-gray-400" />
                  )}
                </>
              )
            },
            { label: 'Phone', name: 'phone' },
            { label: 'Address', name: 'address' },
            { label: 'Address2', name: 'address2' },
            { label: 'City', name: 'city' },
            { label: 'Region', name: 'region' },
            { label: 'Country', name: 'country' },
            { label: 'Postal Code', name: 'postal_code' }
          ]}
          rows={data}
          getRowDetailsUrl={row => route('customers.edit', row.id)}
        />
        <Pagination links={links} />
      </div>
    </div>
)

};

/**
 * Persistent Layout (Inertia.js)
 *
 * [Learn more](https://inertiajs.com/pages#persistent-layouts)
 */
Index.layout = (page: React.ReactNode) => (
  <MainLayout title="Customers" children={page} />
);

export default Index;

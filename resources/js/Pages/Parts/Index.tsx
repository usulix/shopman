import { Link, usePage } from '@inertiajs/react';
import { PaginatedData } from '@/types';
import MainLayout from '@/Layouts/MainLayout';
import Table from '@/Components/Table/Table';
import { Trash2 } from 'lucide-react';
import Pagination from '@/Components/Pagination/Pagination';


const Index = () => {

  const parts = usePage<{
    parts: PaginatedData<Part>;
  }>().props;

  const {
    data,
    links
  } = parts;

  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">Parts</h1>
      <p className="p-6">Step up to the parts counter.</p>
      <div>
        <div>
          <div className="flex items-center justify-between mb-6">
            <Link
              className="btn-indigo focus:outline-none"
              href={route('parts.create')}
            >
              <span>Create</span>
              <span className="hidden md:inline"> Part</span>
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
              { label: 'Name', name: 'name' },
              { label: 'Price', name: 'price'},
              { label: 'Received', name: 'received' },
            ]}
            rows={data}
            getRowDetailsUrl={row => route('parts.edit', row.id)}
          />
          <Pagination links={links} />
        </div>
      </div>
    </div>
  )
}

/**
 * Persistent Layout (Inertia.js)
 *
 * [Learn more](https://inertiajs.com/pages#persistent-layouts)
 */
Index.layout = (page: React.ReactNode) => (
  <MainLayout title="Parts" children={page} />
);

export default Index;

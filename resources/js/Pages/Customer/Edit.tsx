import React from 'react';
import { Head } from '@inertiajs/react';
import { Link, usePage, useForm, router } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import DeleteButton from '@/Components/Button/DeleteButton';
import LoadingButton from '@/Components/Button/LoadingButton';
import TextInput from '@/Components/Form/TextInput';
import TrashedMessage from '@/Components/Messages/TrashedMessage';
import { Customer } from '@/types';
import FieldGroup from '@/Components/Form/FieldGroup';
import Table from '@/Components/Table/Table';
import { Trash2 } from 'lucide-react';
import Pagination from '@/Components/Pagination/Pagination';

const Edit = () => {
  const { customer, units } = usePage<{
    customer: Customer;
    units: Unit[]
  }>().props;

  console.log(units)

  const { data, setData, errors, put, processing } = useForm({
    name: customer.name || '',
    phone: customer.phone || '',
    address: customer.address || '',
    address2: customer.address2 || '',
    city: customer.city || '',
    region: customer.region || '',
    postal_code: customer.postal_code || '',
  });

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    put(route('customers.update', customer.id));
  }

  function destroy() {
    if (confirm('Are you sure you want to delete this contact?')) {
      router.delete(route('customers.destroy', customer.id));
    }
  }

  function restore() {
    if (confirm('Are you sure you want to restore this contact?')) {
      router.put(route('customer.restore', customer.id));
    }
  }

  return (
    <div>
      <Head title={`${data.name}`} />
      <h1 className="mb-8 text-3xl font-bold">
        <Link
          href={route('customers.index')}
          className="text-indigo-600 hover:text-indigo-700"
        >
          Customer
        </Link>
        <span className="mx-2 font-medium text-indigo-600">/</span>
        {data.name}
      </h1>
      {customer.deleted_at && (
        <TrashedMessage
          message="This customer has been deleted."
          onRestore={restore}
        />
      )}
      <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
        <form onSubmit={handleSubmit}>
          <div className="grid gap-8 p-8 lg:grid-cols-2">
            <FieldGroup
              label="Name"
              name="name"
              error={errors.name}
            >
              <TextInput
                name="name"
                error={errors.name}
                value={data.name}
                onChange={e => setData('name', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Phone" name="email" error={errors.phone}>
              <TextInput
                name="phone"
                type="phone"
                error={errors.phone}
                value={data.phone}
                onChange={e => setData('phone', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Address" name="address" error={errors.address}>
              <TextInput
                name="adress"
                error={errors.address}
                value={data.address}
                onChange={e => setData('address', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Address2" name="address2" error={errors.address2}>
              <TextInput
                name="address2"
                error={errors.address2}
                value={data.address2}
                onChange={e => setData('address2', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="City" name="city" error={errors.city}>
              <TextInput
                name="city"
                error={errors.city}
                value={data.city}
                onChange={e => setData('city', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Region" name="region" error={errors.region}>
              <TextInput
                name="region"
                error={errors.region}
                value={data.region}
                onChange={e => setData('region', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Postal Code" name="postal_code" error={errors.postal_code}>
              <TextInput
                name="postal_code"
                error={errors.postal_code}
                value={data.postal_code}
                onChange={e => setData('postal_code', e.target.value)}
              />
            </FieldGroup>
          </div>
          <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
            {!customer.deleted_at && (
              <DeleteButton onDelete={destroy}>Delete Contact</DeleteButton>
            )}
            <LoadingButton
              loading={processing}
              type="submit"
              className="ml-auto btn-indigo"
            >
              Update Customer
            </LoadingButton>
          </div>
        </form>
      </div>
      <div>
        <h1 className="my-8 text-3xl font-bold">Units (vehicles)</h1>
        <div className="flex items-center justify-between mb-6">
          <Link
            className="btn-indigo focus:outline-none"
            href={route('units.create')}
          >
            <span>Create</span>
            <span className="hidden md:inline"> Unit</span>
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
            { label: 'Number', name: 'number' },
            { label: 'Make', name: 'make' },
            { label: 'Model', name: 'model' },
            { label: 'Mileage', name: 'mileage' },
          ]}
          rows={units}
          getRowDetailsUrl={row => route('units.edit', row.id)}
        />
      </div>
    </div>
  );
};

/**
 * Persistent Layout (Inertia.js)
 *
 * [Learn more](https://inertiajs.com/pages#persistent-layouts)
 */
Edit.layout = (page: React.ReactNode) => <MainLayout children={page} />;

export default Edit;

import { Link, usePage, useForm } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import LoadingButton from '@/Components/Button/LoadingButton';
import TextInput from '@/Components/Form/TextInput';
import FieldGroup from '@/Components/Form/FieldGroup';
import SelectInput from '@/Components/Form/SelectInput';
import React from 'react';
import { Customer } from '@/types';

const Create = () => {

  const { customers } = usePage<{
    customers: Customer[];
  }>().props;

  const { data, setData, errors, post, processing } = useForm({
    name: '',
    email: '',
    phone: '',
    customer_id: ''
  });

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    post(route('contacts.store'));
  }

  return (
    <div>
      <h1 className="mb-8 text-3xl font-bold">
        <Link
          href={route('contacts.index')}
          className="text-indigo-600 hover:text-indigo-700"
        >
          Contacts
        </Link>
        <span className="font-medium text-indigo-600"> /</span> Create
      </h1>
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

            <FieldGroup
              label="Customer"
              name="customer_id"
              error={errors.customer_id}
            >
              <SelectInput
                name="customer_id"
                error={errors.customer_id}
                value={data.customer_id}
                onChange={e => setData('customer_id', e.target.value)}
                options={[
                  {
                    value: '',
                    label: ''
                  },
                  ...customers.map(org => ({
                    value: String(org.id),
                    label: org.name
                  }))
                ]}
              />
            </FieldGroup>

            <FieldGroup label="Email" name="email" error={errors.email}>
              <TextInput
                name="email"
                type="email"
                error={errors.email}
                value={data.email}
                onChange={e => setData('email', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Phone" name="phone" error={errors.phone}>
              <TextInput
                name="phone"
                error={errors.phone}
                value={data.phone}
                onChange={e => setData('phone', e.target.value)}
              />
            </FieldGroup>

          </div>
          <div className="flex items-center justify-end px-8 py-4 bg-gray-100 border-t border-gray-200">
            <LoadingButton
              loading={processing}
              type="submit"
              className="btn-indigo"
            >
              Create Contact
            </LoadingButton>
          </div>
        </form>
      </div>
    </div>
  );
};

/**
 * Persistent Layout (Inertia.js)
 *
 * [Learn more](https://inertiajs.com/pages#persistent-layouts)
 */
Create.layout = (page: React.ReactNode) => (
  <MainLayout title="Create Contact" children={page} />
);

export default Create;

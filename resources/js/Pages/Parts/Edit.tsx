import React from 'react';
import { Head } from '@inertiajs/react';
import { Link, usePage, useForm, router } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import DeleteButton from '@/Components/Button/DeleteButton';
import LoadingButton from '@/Components/Button/LoadingButton';
import TextInput from '@/Components/Form/TextInput';
import SelectInput from '@/Components/Form/SelectInput';
import TrashedMessage from '@/Components/Messages/TrashedMessage';
import { Contact, Customer } from '@/types';
import FieldGroup from '@/Components/Form/FieldGroup';

const Edit = () => {
  const { part } = usePage<{
    part: Part;
  }>().props;

  const { data, setData, errors, put, processing } = useForm({
    id: part.id,
    number: part.number || '',
    name: part.name || '',
    price: part.price || '',
    received: part.received || '',
  });

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();
    put(route('parts.update', part.id));
  }

  function destroy() {
    if (confirm('Are you sure you want to delete this part?')) {
      router.delete(route('parts.destroy', part.id));
    }
  }

  function restore() {
    if (confirm('Are you sure you want to restore this part?')) {
      router.put(route('part.restore', part.id));
    }
  }

  return (
    <div>
      <Head title={`${data.name}`} />
      <h1 className="mb-8 text-3xl font-bold">
        <Link
          href={route('parts.index')}
          className="text-indigo-600 hover:text-indigo-700"
        >
          Parts
        </Link>
        <span className="mx-2 font-medium text-indigo-600">/</span>
        {data.name}
      </h1>
      {part.deleted_at && (
        <TrashedMessage
          message="This part has been deleted."
          onRestore={restore}
        />
      )}
      <div className="max-w-3xl overflow-hidden bg-white rounded shadow">
        <form onSubmit={handleSubmit}>
          <div className="grid gap-8 p-8 lg:grid-cols-2">
            <FieldGroup name="id">
              <TextInput
                type="hidden"
                value={data.id}
              />
            </FieldGroup>
            <FieldGroup
              label="Number"
              name="number"
              error={errors.number}
            >
              <TextInput
                name="number"
                error={errors.number}
                value={data.number}
                onChange={e => setData('number', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Name" name="name" error={errors.name}>
              <TextInput
                name="name"
                type="name"
                error={errors.name}
                value={data.name}
                onChange={e => setData('name', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Price" name="price" error={errors.price}>
              <TextInput
                name="price"
                error={errors.price}
                value={data.price}
                onChange={e => setData('price', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Received" name="received" error={errors.received}>
              <TextInput
                name="received"
                error={errors.received}
                value={data.received}
                onChange={e => setData('received', e.target.value)}
              />
            </FieldGroup>

          </div>
          <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
            {!part.deleted_at && (
              <DeleteButton onDelete={destroy}>Delete Part</DeleteButton>
            )}
            <LoadingButton
              loading={processing}
              type="submit"
              className="ml-auto btn-indigo"
            >
              Update Part
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
Edit.layout = (page: React.ReactNode) => <MainLayout children={page} />;

export default Edit;

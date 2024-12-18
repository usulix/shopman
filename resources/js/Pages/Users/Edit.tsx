import React from 'react';
import { Head } from '@inertiajs/react';
import { Link, usePage, useForm, router } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import DeleteButton from '@/Components/Button/DeleteButton';
import LoadingButton from '@/Components/Button/LoadingButton';
import TextInput from '@/Components/Form/TextInput';
import SelectInput from '@/Components/Form/SelectInput';
import FileInput from '@/Components/Form/FileInput';
import TrashedMessage from '@/Components/Messages/TrashedMessage';
import { User } from '@/types';
import FieldGroup from '@/Components/Form/FieldGroup';

const Edit = () => {
  const { user } = usePage<{
    user: User & { password: string };
  }>().props;

  const { data, setData, errors, post, processing } = useForm({
    name: user.name || '',
    email: user.email || '',
    password: user.password || '',
    isOwner: user.isOwner ? '1' : '0' || '0',

    // NOTE: When working with Laravel PUT/PATCH requests and FormData
    // you SHOULD send POST request and fake the PUT request like this.
    _method: 'put'
  });

  function handleSubmit(e: React.FormEvent<HTMLFormElement>) {
    e.preventDefault();

    // NOTE: We are using POST method here, not PUT/PATCH. See comment above.
    post(route('users.update', user.id));
  }

  function destroy() {
    if (confirm('Are you sure you want to delete this user?')) {
      router.delete(route('users.destroy', user.id));
    }
  }

  function restore() {
    if (confirm('Are you sure you want to restore this user?')) {
      router.put(route('users.restore', user.id));
    }
  }

  return (
    <div>
      <Head title={`${data.name}`} />
      <div className="flex justify-start max-w-lg mb-8">
        <h1 className="text-3xl font-bold">
          <Link
            href={route('users')}
            className="text-indigo-600 hover:text-indigo-700"
          >
            Users
          </Link>
          <span className="mx-2 font-medium text-indigo-600">/</span>
          {data.name}
        </h1>
      </div>
      {user.deleted_at && (
        <TrashedMessage
          message="This user has been deleted."
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

            <FieldGroup label="Email" name="email" error={errors.email}>
              <TextInput
                name="email"
                type="email"
                error={errors.email}
                value={data.email}
                onChange={e => setData('email', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup
              label="Password"
              name="password"
              error={errors.password}
            >
              <TextInput
                name="password"
                type="password"
                error={errors.password}
                value={data.password}
                onChange={e => setData('password', e.target.value)}
              />
            </FieldGroup>

            <FieldGroup label="Owner" name="owner" error={errors.owner}>
              <SelectInput
                name="isOwner"
                error={errors.isOwner}
                value={data.isOwner}
                onChange={e => setData('isOwner', e.target.value)}
                options={[
                  { value: '1', label: 'Yes' },
                  { value: '0', label: 'No' }
                ]}
              />
            </FieldGroup>

          </div>
          <div className="flex items-center px-8 py-4 bg-gray-100 border-t border-gray-200">
            {!user.deleted_at && (
              <DeleteButton onDelete={destroy}>Delete User</DeleteButton>
            )}
            <LoadingButton
              loading={processing}
              type="submit"
              className="ml-auto btn-indigo"
            >
              Update User
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

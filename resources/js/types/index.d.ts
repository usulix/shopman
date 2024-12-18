import { Config } from 'ziggy-js';

export interface User {
  id: number;
  name: string;
  email: string;
  isOwner: string;
  deleted_at: string;
  account: Account;
}

export interface Customer {
  id: number;
  name: string;
  phone: string;
  address: string;
  address2: string;
  city: string;
  region: string;
  country: string;
  postal_code: string;
  deleted_at: string;
  Account: Account;
}

export interface Account {
  id: number;
  name: string;
  users: User[];
  contacts: Contact[];
}

export interface Contact {
  id: number;
  name: string;
  email: string;
  phone: string;
}

export type PaginatedData<T> = {
  data: T[];
  links: {
    first: string;
    last: string;
    prev: string | null;
    next: string | null;
  };

  meta: {
    current_page: number;
    from: number;
    last_page: number;
    path: string;
    per_page: number;
    to: number;
    total: number;

    links: {
      url: null | string;
      label: string;
      active: boolean;
    }[];
  };
};

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>
> = T & {
  auth: {
    user: User;
  };
  flash: {
    success: string | null;
    error: string | null;
  };
  ziggy: Config & { location: string };
};


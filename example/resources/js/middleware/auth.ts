import type { NavigationGuardNext } from 'vue-router';
import { useAuth } from '@/stores/auth-store';
import { storeToRefs } from 'pinia';

export default async (
  to: Object,
  from: Object,
  next: NavigationGuardNext
): Promise<void> => {
  const { user, token } = storeToRefs(useAuth());
  const { fetchUser } = useAuth();
  console.log(token.value);
  if (!token.value) {
    next({ name: 'login' });
    return;
  }

  if (!user?.value?.email) {
    await fetchUser();
  }
  next();
};

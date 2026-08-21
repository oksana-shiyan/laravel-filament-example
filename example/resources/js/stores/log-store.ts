import { defineStore } from 'pinia';
import LogService from '@/services/log-service'
import { LogCollectionResponse, LogResource } from "@/types/log";

export const useLog = defineStore('log', (): UseUsers => {
  const service = new LogService();

  const fetchFiles = async (): Promise<Array<LogResource>> => {
    const data:LogCollectionResponse = await service.list();
      return data.files
  };

  const download = async (key: string): Promise<void> => {
    try {
        const data = await service.download(key);
        const fileName = `logs.txt`
        const url = window.URL.createObjectURL(new Blob([data]))
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', fileName)
        document.body.appendChild(link)
        link.click()
    } catch (e) {
      throw e;
    }
  };

    return { fetchFiles, download };
});

export interface UseUsers {
    fetchFiles: () => Promise<Array<LogResource>>;
    download: (key: string) => Promise<void>;
}
